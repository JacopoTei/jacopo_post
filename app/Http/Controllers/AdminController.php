<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard() {
        $adminRequests = User::where('is_admin', null)->get();
        $revisorRequests = User::where('is_revisor', null)->get();
        $writerRequests = User::where('is_writer', null)->get();
    
        return view('admin.dashboard', compact('adminRequests', 'revisorRequests', 'writerRequests'));
    }

    public function setAdmin(User $user) {
        $user->update([
            'is_admin' => true,
        ]);
        
        return redirect(route('admin.dashboard'))->with('message' , 'Hai correttamente reso amministratore l\'utente scelto');
        
    }
    public function setRevisor(User $user) {
        $user->update([
            'is_revisor' => true,
        ]);
        
        return redirect(route('admin.dashboard'))->with('message' , 'Hai correttamente reso revisore l\'utente scelto');
        
    }
    public function setWriter(User $user) {
        $user->update([
            'is_writer' => true,
        ]);
        
        return redirect(route('admin.dashboard'))->with('message' , 'Hai correttamente reso redattore l\'utente scelto');
        
    }


    
}
