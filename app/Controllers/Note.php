<?php

namespace App\Controllers;

use App\System\CRequest;
use App\Models\MvcUserModel;
use App\Models\MvcDataModel;
use App\Models\MvcNoteModel;
use App\System\Hash;
use App\System\JavaScript;
use App\System\PageNotFoundException;

class Note
{
    public function __construct()
    {
        // parent::__construct();
        // Auth::handleLogin();
    }

    public function index()
    {
        $session = session();
        $userid = $session->get('userid');

        $model = model(MvcNoteModel::class);

        $data = $model->where('userid', $userid)->findAll();

        return view('mvc/header', ['title' => 'Notes'])
            . view('mvc/note/index', ['noteList' => $data])
            . view('mvc/footer');
    }

    public function create()
    {
        $request = new CRequest();
        $data = $request->getPost(['title', 'content']);

        $session = session();
        $data['userid'] = $session->get('userid');
        $data['date_added'] = date('Y-m-d H:i:s');

        $model = model(MvcNoteModel::class);
        $model->save($data);

        return JavaScript::redirect('../note');
    }

    public function edit($noteid)
    {
        // $this->view->note = $this->model->noteSingleList($noteid);

        $model = model(MvcNoteModel::class);

        $note = $model->find($noteid);
        if ($note === null) {
            throw new PageNotFoundException('This is an invalid note!');
        }

        // $this->view->title = 'Edit Note';

        // $this->view->render('header');
        // $this->view->render('note/edit');
        // $this->view->render('footer');

        return view('mvc/header', ['title' => 'Edit Note'])
            . view('mvc/note/edit', ['note' => $note])
            . view('mvc/footer');
    }

    public function editSave($noteid)
    {
        // $data = [
        //     'noteid' => $noteid,
        //     'title' => $_POST['title'],
        //     'content' => $_POST['content'],
        // ];
        //
        // $this->model->editSave($data);
        // header('location: '.URL.'note');

        $request = new CRequest();
        $data = $request->getPost(['title', 'content']);

        // @TODO: Do your checking!

        $session = session();
        $userid = $session->get('userid');

        $model = model(MvcNoteModel::class);

        $model->where('noteid', $noteid)
              ->where('userid', $userid)
              ->set($data)
              ->update();

        return JavaScript::redirect('../');
    }

    public function delete($id)
    {
        // $this->model->delete($id);
        // header('location: '.URL.'note');

        $model = model(MvcNoteModel::class);
        $model->delete($id);
        return JavaScript::redirect('../');
    }
}





// public function noteList()
//     {
//         return $this->db->select(
//             'SELECT * FROM note WHERE userid = :userid',
//                 ['userid' => $_SESSION['userid']]
//         );
//     }

//     public function noteSingleList($noteid)
//     {
//         return $this->db->select(
//             'SELECT * FROM note WHERE userid = :userid AND noteid = :noteid',
//                 ['userid' => $_SESSION['userid'], 'noteid' => $noteid]
//         );
//     }

//     public function create($data)
//     {
//         $this->db->insert('note', [
//             'title' => $data['title'],
//             'userid' => $_SESSION['userid'],
//             'content' => $data['content'],
//             'date_added' => date('Y-m-d H:i:s'), // use GMT aka UTC 0:00
//         ]);
//     }

//     public function editSave($data)
//     {
//         $postData = [
//             'title' => $data['title'],
//             'content' => $data['content'],
//         ];

//         $this->db->update(

//             'note',

//             $postData,
//                 "`noteid` = '{$data['noteid']}' AND `userid` = '{$_SESSION['userid']}'"

//         );
//     }

//     public function delete($noteid)
//     {
//         $this->db->delete('note', "`noteid` = '$noteid' AND `userid` = '{$_SESSION['userid']}'");
//     }
