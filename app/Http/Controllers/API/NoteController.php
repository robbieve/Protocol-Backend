<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Events\AddPointEvent;
use App\Events\AddNotificationEvent;
use App\Events\UpdateSaveBoardEvent;
class NoteController extends Controller
{
    private $fieldsRequired = [
        'target',
        'title',
        'tags',
        'desc',
        'privacy',
        'relation'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user           = Auth::guard('api')->user();
        $whereInFields  = ['target'];
        $queryWhereIn   = array_filter(
            $request->query(),
            function ($k) use($whereInFields) { return in_array($k, $whereInFields); },
            ARRAY_FILTER_USE_KEY
        );

        $builder = \App\Note::where('status', 0)->with(['followUser'=>function($q)use($user){
            $q->where('follower_id',$user->id);
        }]);

        foreach ($queryWhereIn as $k => $v) {
            $arr = is_array($v) ? $v : [$v];
            $builder = $builder->whereIn($k, $arr);
        }

        $builder = $this->withPrivacyWhere($builder, $user);
        $notes = $builder->get();
        //add isfollowtag
        $notes = $this->checkFollow($notes);

        return $this->apiOk($notes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $note = new \App\Note;

        foreach ($this->fieldsRequired as $f) {
            $note->$f = $request->$f;
        }
        $note->created_by = $request->user()['id'];
        $note->category = $request->get('category');
        $note->sub_category = $request->get('sub_category');
        $note->save();
        // Update referral point
        $pointData['user_id'] = $request->user()['id'];
        $pointData['type'] = 2;
        $pointData['type_id'] = $note->id;
        $pointData['point'] = 1;
        //update change status of the saveboard element
        $request['is_note'] = 1;
        event(new AddPointEvent($pointData));
        event(new UpdateSaveBoardEvent($request->all()));
        return $this->apiOk($note);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $note = \App\Note::findOrFail($id);
        return $this->apiOk($note);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user   = $request->user();
        $note   = \App\Note::findOrFail($id);

        if ($user['admin'] !== 1 && $user['id'] !== $note['created_by']) {
            return $this->apiErr(222003, 'Not Authorized');
        }

        foreach ($this->fieldsRequired as $f) {
            $note->$f = $request->$f;
        }
        $note->sub_category = $request->get('sub_category');
        $note->category = $request->get('category');
        $note->updated_by = $user['id'];
        $note->save();

        return $this->apiOk($note);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $user   = $request->user();
        $note   = \App\Note::findOrFail($id);

        if ($user['admin'] !== 1 && $user['id'] !== $note['created_by']) {
            return $this->apiErr(222003, 'Not Authorized');
        }

        $note->status       = 1;
        $note->updated_by   = $user['id'];
        $note->save();

        return $this->apiOk(true);
    }
}
