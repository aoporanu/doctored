<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;
use App\Modules\Admin\Controllers\AdminIndexController as AdminIndexController;
use Redirect;
use Log;
use Exception;
use App\Modules\Admin\Models\SiteManagement as SiteManagement;

class SiteManagementController extends AdminIndexController {
    private $_url_key = '/admin/sitemanagement';
    public function manage(Request $request) {
        try {
            $this->setData($this->_url_key, 'view');
            $requestParams = $this->filterParameters($request->all());
            $siteId = isset($requestParams['id']) ? $requestParams['id'] : 1;

            $site_details = SiteManagement::find($siteId);
            if ($requestParams) {
                $site_details->sitename = $request->sitename;

                if ($request->hasFile('favicon')) {
                    if ($request->file('favicon')->isValid()) {
                        try {
                            $this->validate($request, [
                                'favicon' => 'required|image|mimes:jpeg,png,jpg,gif,svg,ico|max:2048',
                            ]);
                            $file = $request->file('favicon');
                            $favicon = $file->getClientOriginalName();
                            $request->file('favicon')->move("Sitemanagement", $favicon);
                            $site_details->favicon = $favicon;
                        } catch (Illuminate\Filesystem\FileNotFoundException $e) {
                            
                        }
                    }
                }

                if ($request->hasFile('logo_big')) {
                    if ($request->file('logo_big')->isValid()) {
                        try {
                            $this->validate($request, [
                                'logo_big' => 'required|image|mimes:jpeg,png,jpg,gif,svg,ico|max:2048',
                            ]);
                            $file = $request->file('logo_big');
                            $logo_big = $file->getClientOriginalName();
                            $request->file('logo_big')->move("Sitemanagement", $logo_big);
                            $site_details->logo_big = $logo_big;
                        } catch (Illuminate\Filesystem\FileNotFoundException $e) {
                            
                        }
                    }
                }

                if ($request->hasFile('logo_small')) {
                    if ($request->file('logo_small')->isValid()) {
                        try {
                            $this->validate($request, [
                                'logo_small' => 'required|image|mimes:jpeg,png,jpg,gif,svg,ico|max:2048',
                            ]);
                            $file = $request->file('logo_small');
                            $logo_small = $file->getClientOriginalName();
                            $request->file('logo_small')->move("Sitemanagement", $logo_small);
                            $site_details->logo_small = $logo_small;
                        } catch (Illuminate\Filesystem\FileNotFoundException $e) {
                            
                        }
                    }
                }


                if ($request->hasFile('banner')) {
                    if ($request->file('banner')->isValid()) {
                        try {
                            $this->validate($request, [
                                'banner' => 'required|image|mimes:jpeg,png,jpg,gif,svg,ico|max:2048',
                            ]);
                            $file = $request->file('banner');
                            $banner = $file->getClientOriginalName();
                            $request->file('banner')->move("Sitemanagement", $banner);
                            $site_details->banner = $banner;
                        } catch (Illuminate\Filesystem\FileNotFoundException $e) {
                            
                        }
                    }
                }



                $site_details->meta_keyword = $request->meta_keyword;
                $site_details->meta_description = $request->meta_description;
                $site_details->meta_author = $request->meta_author;
                $site_details->meta_viewport = $request->meta_viewport;
                $site_details->copyright = $request->copyright;
                $site_details->footerdescription = $request->footerdescription;
                $site_details->footer_social = $request->footer_social;
                $site_details->save();
            }

            return view('Admin::sitemanagement/manage_site')->with(['site_details' => $site_details]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

}

?>