<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Google\Cloud\Firestore\FirestoreClient;

class TaskController extends Controller
{
    protected $firestore;

    public function __construct()
    {
        $this->firestore = new FirestoreClient([
            'projectId' => 'laravel-firebase-taskapp',
            'keyFilePath' => base_path('storage/firebase_credentials.json') // ✅ fix your path
        ]);
    }

    public function index()
    {
        return view('dashboard', ['email' => session('email')]);
    }

 public function add_task()
    {
        return view('add_task');
    }





    public function verifyUser(Request $request)
    {
        $uid = $request->uid;
        $email = $request->email;

        $user = User::where('firebase_uid', $uid)
                    ->orWhere('email', $email)
                    ->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        session(['uid' => $uid, 'email' => $email, 'role' => $user->role]);

        return response()->json(['success' => true, 'role' => $user->role]);
    }



    
  public function saveTask(Request $request)
{
    try {
        $collection = $this->firestore->collection('tasks');

        $collection->add([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'due_date' => $request->due_date,
            'assignedTo' => $request->assigned_to,
            'created_at' => now()
        ]);

        return redirect()->back()->with('success', 'Task added!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
    }
}






    public function getTasks(Request $request)
    {
        $email = $request->email;

        $documents = $this->firestore
            ->collection('tasks')
            ->where('assignedTo', '=', $email)
            ->documents();

        $tasks = [];
        foreach ($documents as $doc) {
            if ($doc->exists()) {
                $data = $doc->data();
                $data['id'] = $doc->id();
                $tasks[] = $data;
            }
        }

        return response()->json(['tasks' => $tasks]);
    }
}
