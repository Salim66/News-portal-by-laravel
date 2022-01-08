<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * index page load
     */
    public function index(){
        return view('frontend.home.index');
    }

    /**
     * Language change
     */
    public function changeLanguage($id){
        if($id == 1){
            $english = Language::findOrFail($id);
            $bangla = Language::findOrFail(2);
            $english->status = true;
            $english->update();
            $bangla->status = false;
            $bangla->update();

            return redirect()->back();

        }else if($id == 2) {
            $english = Language::findOrFail(1);
            $bangla = Language::findOrFail($id);
            $english->status = false;
            $english->update();
            $bangla->status = true;
            $bangla->update();

            return redirect()->back();

        }
    }

}
