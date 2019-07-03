<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Bar;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $header_data = [
            'main_name'   => 'Groups',
            'parent_data' => [
                ['parent_name' => 'Settings', 'parent_url' => ''],
            ]
        ];
        
        $groups = Group::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->paginate(10);
        
        return view('users.groups-list', compact('header_data', 'groups'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $header_data = [
            'main_name'   => 'New Group',
            'parent_data' => [
                ['parent_name' => 'Settings', 'parent_url' => ''],
                ['parent_name' => 'Groups', 'parent_url' => secure_redirect(route('groups'))],
            ]
        ];
        
        $flag = true;
        $form_action = secure_redirect(route('groups.store'));
        
        return view('users.groups-edit', compact('header_data', 'flag', 'form_action'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:200'
        ]);
        
        $ins_data = [
            'user_id' => auth()->user()->id,
            'name'    => $request->input('name'),
            'notes'   => is_null($request->input('notes')) ? '' : $request->input('notes'),
            'tags'    => is_null($request->input('tags')) ? '' : $request->input('tags'),
        ];
        
        Group::insertGetId($ins_data);
        
        session()->flash('success', 'Successfully Created');
        
        return response()->redirectTo('groups');
    }
    
    /**
     * Display the specified resource.
     *
     * @param \App\Models\Group $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        //
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Group $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        $header_data = [
            'main_name'   => 'Edit Group',
            'parent_data' => [
                ['parent_name' => 'Settings', 'parent_url' => ''],
                ['parent_name' => 'Groups', 'parent_url' => secure_redirect(route('groups'))],
            ]
        ];
        
        $flag = false;
        $form_action = secure_redirect(route('groups.update', ['group' => $group->id]));
        
        return view('users.groups-edit', compact('header_data', 'flag', 'form_action', 'group'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Group $group
     * @return \Illuminate\Http\Response
     * @throws
     */
    public function update(Request $request, Group $group)
    {
        if ($request->has('flag')) {
            if ($request->input('flag') == 'clone') {
                $duplicate_row = $group->replicate(['id', 'created_at', 'updated_at']);
                $duplicate_row->name = $group->name . ' - Clone';
                $duplicate_row->save();
                
                session()->flash('success', 'Tracker has been cloned.');
                
                return response()->json([
                    'result' => 'success',
                    'id'     => $duplicate_row->id
                ]);
            }
        } else {
            $this->validate($request, [
                'name' => 'required|max:200'
            ]);
            
            $group->fill($request->all());
            
            $group->save();
            
            session()->flash('success', 'Successfully Updated');
        }
        
        return response()->redirectTo('groups');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Group $group
     * @return \Illuminate\Http\Response
     * @throws
     */
    public function destroy(Group $group)
    {
        $group_id = $group->id;
        
        Bar::where('group_id', $group_id)->delete();
        $group->delete();
        
        session()->flash('success', 'Successfully Deleted');
        
        return response()->json([
            'result' => 'success'
        ]);
    }
}