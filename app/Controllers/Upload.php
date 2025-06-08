<?php

namespace App\Controllers;

class Upload
{
    protected $helpers = ['form'];

    public function index()
    {
        return view('upload_form', ['errors' => []]);
    }

    public function upload()
    {
        // $validationRule = [
        //     'userfile' => [
        //         'label' => 'Image File',
        //         'rules' => [
        //             'uploaded[userfile]',
        //             'is_image[userfile]',
        //             'mime_in[userfile,image/jpg,image/jpeg,image/gif,image/png,image/webp]',
        //             'max_size[userfile,100]',  // 100 KB
        //             'max_dims[userfile,1024,768]',
        //         ],
        //     ],
        // ];

        // if (! $this->validateData([], $validationRule)) {
        //     $data = ['errors' => $this->validator->getErrors()];

        //     return view('upload_form', $data);
        // }

        $request = new CRequest();
        $img = $request->getFile('userfile');

// echo "<pre>";print_r($img->file);echo "</pre>";exit;

        // $img = $this->request->getFile('userfile');

        // if (! $img->hasMoved()) {
            $filepath = WRITEPATH . 'uploads/' . $img->store();

            $data = ['uploaded_fileinfo' => new File($filepath)];

            return view('upload_success', $data);
        // }

        $data = ['errors' => 'The file has already been moved.'];

        return view('upload_form', $data);
    }

}
