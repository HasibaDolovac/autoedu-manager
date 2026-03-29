<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index() {
        $obavestenja = Announcement::latest()->get();
        return view('admin.obavestenja', compact('obavestenja'));
    }

    public function store(Request $request) {
        $request->validate([
            'naslov' => 'required',
            'poruka' => 'required'
        ]);

        Announcement::create($request->all());

        return redirect()->back()->with('status', 'Obaveštenje je uspešno objavljeno!');
    }

    //brisanje obavestenja
    public function destroy($id) {
    $obavestenje = Announcement::findOrFail($id);
    $obavestenje->delete();
    return redirect()->back()->with('status', 'Obaveštenje je uspešno obrisano!');
}


}

