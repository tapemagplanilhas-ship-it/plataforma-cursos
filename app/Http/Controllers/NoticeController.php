<?php
namespace App\Http\Controllers;
use App\Models\Notice;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function index() {
        $notices = Notice::where('active', 1)->orderBy('created_at', 'desc')->paginate(10);
        return view('notices.index', ['notices' => $notices]);
    }

    public function store(Request $request) {
        $request->validate(['title' => 'required', 'content' => 'required', 'target_role' => 'required']);
        Notice::create($request->all());
        return redirect('/notices')->with('success', '✅ Aviso publicado!');
    }


    public function destroy(Notice $notice) {
        $notice->delete();
        return redirect('/notices')->with('success', 'Aviso removido.');
    }

    public function getActiveNotices()
    {
        $notices = Notice::where('active', 1)->orderBy('created_at', 'desc')->get();
        return response()->json($notices);
    }
}