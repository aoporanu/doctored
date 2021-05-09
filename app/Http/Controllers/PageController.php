<?php

namespace App\Http\Controllers;

use App\Page;
use App\Page_elements;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show($page)
    {
        //
        
        $pagedata = DB::table('pages')->where('slug',$page)->first();
        if(isset($pagedata->id)){
        $pid =$pagedata->id;
        $page_elements = DB::table('page_elements')->where('page_id',$pid)->get();
        }else{
            $page_elements = array();
        }
        //$page_elements = DB::table('page_elements')->where('slug',$page)->get();
        //Need to add logic to fetch all elements for the $slug
        return view('pages.index', ['pagedata' => $pagedata,'page_elements'=>$page_elements]);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        //
    }

    public function login(){
        return view('pages.login');
    }

    public function register(){
        return view('pages.register');
    }

}
