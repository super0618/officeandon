<?php

class DashboardController
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function profile()
    {
        return view('dashboard.profile',['page'=>'notifications']);
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function establishments()
    {
        return view('dashboard.establishments',['page'=>'establishments']);
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function newDocument()
    {
        return view('dashboard.newdocument');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function carnetsanitaire()
    {
        return view('dashboard.carnetsanitaire',['page'=>'cs_summary']);
    }
    public function formrequest()
    {
        return view('dashboard.documents.formrequest');
    }
    public function showDocument($id,$docpage=null)
    {
        // TODO: Check if user has access to document
        $document = Book::find($id);
        $tabs=[
            ['name'=>'cs_summary','display'=>'Aperçu Generale', 'active'=>true],
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$document->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
        ];
        /*$pages = $document->pages()->get();
        foreach ($pages as $page){
            $tab = ['name'=>'doc_page','display'=>$page->name, 'model_id'=>$page->id];
            array_push($tabs,$tab);
        }
        */
        // TODO: Add access to user_books
        return view('dashboard.document', ['page'=>'doc_page','tabs'=>$tabs, 'document'=>$document]);
    }
    public function showCompany($id)
    {
        // TODO: Check if user has access to document
        $company = Company::find($id);
        $tabs=[
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$company->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
            ['name'=>'cs_documents','display'=>'Documents',]
            ,
        ];

        return view('dashboard.establishments', ['page'=>'doc_page','tabs'=>$tabs, 'company'=>$company]);
    }

    public function showForm($id,$input_id){
        // return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
        $form = Form::find($id);
        $categories = Category::all();
        //return view('frontpage.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'categories'=>$categories,'form'=>$form,'showForm'=>true]);
         return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
    }


    public function getGraphData($id)
    {
        $graph = CompanyGraph::where('id', $id)->first();
        $graph_datasource = $graph->companyGraphDataSources()->first();
        $data = [];
        $jsonGraphData = [];
        if($graph_datasource->data_source_type == 'Csv')
        {
            $filePath = public_path('data.csv');
            $file = fopen($filePath, 'r');
            $graphdata = [];
            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                $graphdata[] = $data[0];
            }
            fclose($file);
            $jsonGraphData = $graphdata;
            return $jsonGraphData;
        }
        else if($graph_datasource->data_source_type == 'Api')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'FormInput')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'S3_file')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
    }

    public function showDocument($id,$docpage=null)
    {
        // TODO: Check if user has access to document
        $document = Book::find($id);
        $tabs=[
            ['name'=>'cs_summary','display'=>'Aperçu Generale', 'active'=>true],
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$document->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
        ];
        /*$pages = $document->pages()->get();
        foreach ($pages as $page){
            $tab = ['name'=>'doc_page','display'=>$page->name, 'model_id'=>$page->id];
            array_push($tabs,$tab);
        }
        */
        // TODO: Add access to user_books
        return view('dashboard.document', ['page'=>'doc_page','tabs'=>$tabs, 'document'=>$document]);
    }
    public function showCompany($id)
    {
        // TODO: Check if user has access to document
        $company = Company::find($id);
        $tabs=[
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$company->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
            ['name'=>'cs_documents','display'=>'Documents',]
            ,
        ];

        return view('dashboard.establishments', ['page'=>'doc_page','tabs'=>$tabs, 'company'=>$company]);
    }

    public function showForm($id,$input_id){
        // return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
        $form = Form::find($id);
        $categories = Category::all();
        //return view('frontpage.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'categories'=>$categories,'form'=>$form,'showForm'=>true]);
         return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
    }


    public function getGraphData($id)
    {
        $graph = CompanyGraph::where('id', $id)->first();
        $graph_datasource = $graph->companyGraphDataSources()->first();
        $data = [];
        $jsonGraphData = [];
        if($graph_datasource->data_source_type == 'Csv')
        {
            $filePath = public_path('data.csv');
            $file = fopen($filePath, 'r');
            $graphdata = [];
            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                $graphdata[] = $data[0];
            }
            fclose($file);
            $jsonGraphData = $graphdata;
            return $jsonGraphData;
        }
        else if($graph_datasource->data_source_type == 'Api')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'FormInput')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'S3_file')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
    }

    public function showDocument($id,$docpage=null)
    {
        // TODO: Check if user has access to document
        $document = Book::find($id);
        $tabs=[
            ['name'=>'cs_summary','display'=>'Aperçu Generale', 'active'=>true],
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$document->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
        ];
        /*$pages = $document->pages()->get();
        foreach ($pages as $page){
            $tab = ['name'=>'doc_page','display'=>$page->name, 'model_id'=>$page->id];
            array_push($tabs,$tab);
        }
        */
        // TODO: Add access to user_books
        return view('dashboard.document', ['page'=>'doc_page','tabs'=>$tabs, 'document'=>$document]);
    }
    public function showCompany($id)
    {
        // TODO: Check if user has access to document
        $company = Company::find($id);
        $tabs=[
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$company->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
            ['name'=>'cs_documents','display'=>'Documents',]
            ,
        ];

        return view('dashboard.establishments', ['page'=>'doc_page','tabs'=>$tabs, 'company'=>$company]);
    }

    public function showForm($id,$input_id){
        // return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
        $form = Form::find($id);
        $categories = Category::all();
        //return view('frontpage.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'categories'=>$categories,'form'=>$form,'showForm'=>true]);
         return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
    }


    public function getGraphData($id)
    {
        $graph = CompanyGraph::where('id', $id)->first();
        $graph_datasource = $graph->companyGraphDataSources()->first();
        $data = [];
        $jsonGraphData = [];
        if($graph_datasource->data_source_type == 'Csv')
        {
            $filePath = public_path('data.csv');
            $file = fopen($filePath, 'r');
            $graphdata = [];
            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                $graphdata[] = $data[0];
            }
            fclose($file);
            $jsonGraphData = $graphdata;
            return $jsonGraphData;
        }
        else if($graph_datasource->data_source_type == 'Api')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'FormInput')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'S3_file')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
    }

    public function showDocument($id,$docpage=null)
    {
        // TODO: Check if user has access to document
        $document = Book::find($id);
        $tabs=[
            ['name'=>'cs_summary','display'=>'Aperçu Generale', 'active'=>true],
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$document->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
        ];
        /*$pages = $document->pages()->get();
        foreach ($pages as $page){
            $tab = ['name'=>'doc_page','display'=>$page->name, 'model_id'=>$page->id];
            array_push($tabs,$tab);
        }
        */
        // TODO: Add access to user_books
        return view('dashboard.document', ['page'=>'doc_page','tabs'=>$tabs, 'document'=>$document]);
    }
    public function showCompany($id)
    {
        // TODO: Check if user has access to document
        $company = Company::find($id);
        $tabs=[
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$company->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
            ['name'=>'cs_documents','display'=>'Documents',]
            ,
        ];

        return view('dashboard.establishments', ['page'=>'doc_page','tabs'=>$tabs, 'company'=>$company]);
    }

    public function showForm($id,$input_id){
        // return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
        $form = Form::find($id);
        $categories = Category::all();
        //return view('frontpage.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'categories'=>$categories,'form'=>$form,'showForm'=>true]);
         return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
    }


    public function getGraphData($id)
    {
        $graph = CompanyGraph::where('id', $id)->first();
        $graph_datasource = $graph->companyGraphDataSources()->first();
        $data = [];
        $jsonGraphData = [];
        if($graph_datasource->data_source_type == 'Csv')
        {
            $filePath = public_path('data.csv');
            $file = fopen($filePath, 'r');
            $graphdata = [];
            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                $graphdata[] = $data[0];
            }
            fclose($file);
            $jsonGraphData = $graphdata;
            return $jsonGraphData;
        }
        else if($graph_datasource->data_source_type == 'Api')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'FormInput')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'S3_file')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
    }

    public function showDocument($id,$docpage=null)
    {
        // TODO: Check if user has access to document
        $document = Book::find($id);
        $tabs=[
            ['name'=>'cs_summary','display'=>'Aperçu Generale', 'active'=>true],
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$document->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
        ];
        /*$pages = $document->pages()->get();
        foreach ($pages as $page){
            $tab = ['name'=>'doc_page','display'=>$page->name, 'model_id'=>$page->id];
            array_push($tabs,$tab);
        }
        */
        // TODO: Add access to user_books
        return view('dashboard.document', ['page'=>'doc_page','tabs'=>$tabs, 'document'=>$document]);
    }
    public function showCompany($id)
    {
        // TODO: Check if user has access to document
        $company = Company::find($id);
        $tabs=[
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$company->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
            ['name'=>'cs_documents','display'=>'Documents',]
            ,
        ];

        return view('dashboard.establishments', ['page'=>'doc_page','tabs'=>$tabs, 'company'=>$company]);
    }

    public function showForm($id,$input_id){
        // return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
        $form = Form::find($id);
        $categories = Category::all();
        //return view('frontpage.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'categories'=>$categories,'form'=>$form,'showForm'=>true]);
         return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
    }


    public function getGraphData($id)
    {
        $graph = CompanyGraph::where('id', $id)->first();
        $graph_datasource = $graph->companyGraphDataSources()->first();
        $data = [];
        $jsonGraphData = [];
        if($graph_datasource->data_source_type == 'Csv')
        {
            $filePath = public_path('data.csv');
            $file = fopen($filePath, 'r');
            $graphdata = [];
            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                $graphdata[] = $data[0];
            }
            fclose($file);
            $jsonGraphData = $graphdata;
            return $jsonGraphData;
        }
        else if($graph_datasource->data_source_type == 'Api')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'FormInput')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'S3_file')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
    }

    public function showDocument($id,$docpage=null)
    {
        // TODO: Check if user has access to document
        $document = Book::find($id);
        $tabs=[
            ['name'=>'cs_summary','display'=>'Aperçu Generale', 'active'=>true],
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$document->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
        ];
        /*$pages = $document->pages()->get();
        foreach ($pages as $page){
            $tab = ['name'=>'doc_page','display'=>$page->name, 'model_id'=>$page->id];
            array_push($tabs,$tab);
        }
        */
        // TODO: Add access to user_books
        return view('dashboard.document', ['page'=>'doc_page','tabs'=>$tabs, 'document'=>$document]);
    }
    public function showCompany($id)
    {
        // TODO: Check if user has access to document
        $company = Company::find($id);
        $tabs=[
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$company->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
            ['name'=>'cs_documents','display'=>'Documents',]
            ,
        ];

        return view('dashboard.establishments', ['page'=>'doc_page','tabs'=>$tabs, 'company'=>$company]);
    }

    public function showForm($id,$input_id){
        // return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
        $form = Form::find($id);
        $categories = Category::all();
        //return view('frontpage.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'categories'=>$categories,'form'=>$form,'showForm'=>true]);
         return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
    }


    public function getGraphData($id)
    {
        $graph = CompanyGraph::where('id', $id)->first();
        $graph_datasource = $graph->companyGraphDataSources()->first();
        $data = [];
        $jsonGraphData = [];
        if($graph_datasource->data_source_type == 'Csv')
        {
            $filePath = public_path('data.csv');
            $file = fopen($filePath, 'r');
            $graphdata = [];
            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                $graphdata[] = $data[0];
            }
            fclose($file);
            $jsonGraphData = $graphdata;
            return $jsonGraphData;
        }
        else if($graph_datasource->data_source_type == 'Api')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'FormInput')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'S3_file')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
    }

    public function showDocument($id,$docpage=null)
    {
        // TODO: Check if user has access to document
        $document = Book::find($id);
        $tabs=[
            ['name'=>'cs_summary','display'=>'Aperçu Generale', 'active'=>true],
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$document->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
        ];
        /*$pages = $document->pages()->get();
        foreach ($pages as $page){
            $tab = ['name'=>'doc_page','display'=>$page->name, 'model_id'=>$page->id];
            array_push($tabs,$tab);
        }
        */
        // TODO: Add access to user_books
        return view('dashboard.document', ['page'=>'doc_page','tabs'=>$tabs, 'document'=>$document]);
    }
    public function showCompany($id)
    {
        // TODO: Check if user has access to document
        $company = Company::find($id);
        $tabs=[
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$company->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
            ['name'=>'cs_documents','display'=>'Documents',]
            ,
        ];

        return view('dashboard.establishments', ['page'=>'doc_page','tabs'=>$tabs, 'company'=>$company]);
    }

    public function showForm($id,$input_id){
        // return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
        $form = Form::find($id);
        $categories = Category::all();
        //return view('frontpage.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'categories'=>$categories,'form'=>$form,'showForm'=>true]);
         return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
    }


    public function getGraphData($id)
    {
        $graph = CompanyGraph::where('id', $id)->first();
        $graph_datasource = $graph->companyGraphDataSources()->first();
        $data = [];
        $jsonGraphData = [];
        if($graph_datasource->data_source_type == 'Csv')
        {
            $filePath = public_path('data.csv');
            $file = fopen($filePath, 'r');
            $graphdata = [];
            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                $graphdata[] = $data[0];
            }
            fclose($file);
            $jsonGraphData = $graphdata;
            return $jsonGraphData;
        }
        else if($graph_datasource->data_source_type == 'Api')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'FormInput')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'S3_file')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
    }

    public function showDocument($id,$docpage=null)
    {
        // TODO: Check if user has access to document
        $document = Book::find($id);
        $tabs=[
            ['name'=>'cs_summary','display'=>'Aperçu Generale', 'active'=>true],
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$document->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
        ];
        /*$pages = $document->pages()->get();
        foreach ($pages as $page){
            $tab = ['name'=>'doc_page','display'=>$page->name, 'model_id'=>$page->id];
            array_push($tabs,$tab);
        }
        */
        // TODO: Add access to user_books
        return view('dashboard.document', ['page'=>'doc_page','tabs'=>$tabs, 'document'=>$document]);
    }
    public function showCompany($id)
    {
        // TODO: Check if user has access to document
        $company = Company::find($id);
        $tabs=[
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$company->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
            ['name'=>'cs_documents','display'=>'Documents',]
            ,
        ];

        return view('dashboard.establishments', ['page'=>'doc_page','tabs'=>$tabs, 'company'=>$company]);
    }

    public function showForm($id,$input_id){
        // return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
        $form = Form::find($id);
        $categories = Category::all();
        //return view('frontpage.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'categories'=>$categories,'form'=>$form,'showForm'=>true]);
         return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
    }


    public function getGraphData($id)
    {
        $graph = CompanyGraph::where('id', $id)->first();
        $graph_datasource = $graph->companyGraphDataSources()->first();
        $data = [];
        $jsonGraphData = [];
        if($graph_datasource->data_source_type == 'Csv')
        {
            $filePath = public_path('data.csv');
            $file = fopen($filePath, 'r');
            $graphdata = [];
            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                $graphdata[] = $data[0];
            }
            fclose($file);
            $jsonGraphData = $graphdata;
            return $jsonGraphData;
        }
        else if($graph_datasource->data_source_type == 'Api')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'FormInput')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'S3_file')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
    }

    public function showDocument($id,$docpage=null)
    {
        // TODO: Check if user has access to document
        $document = Book::find($id);
        $tabs=[
            ['name'=>'cs_summary','display'=>'Aperçu Generale', 'active'=>true],
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$document->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
        ];
        /*$pages = $document->pages()->get();
        foreach ($pages as $page){
            $tab = ['name'=>'doc_page','display'=>$page->name, 'model_id'=>$page->id];
            array_push($tabs,$tab);
        }
        */
        // TODO: Add access to user_books
        return view('dashboard.document', ['page'=>'doc_page','tabs'=>$tabs, 'document'=>$document]);
    }
    public function showCompany($id)
    {
        // TODO: Check if user has access to document
        $company = Company::find($id);
        $tabs=[
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$company->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
            ['name'=>'cs_documents','display'=>'Documents',]
            ,
        ];

        return view('dashboard.establishments', ['page'=>'doc_page','tabs'=>$tabs, 'company'=>$company]);
    }

    public function showForm($id,$input_id){
        // return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
        $form = Form::find($id);
        $categories = Category::all();
        //return view('frontpage.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'categories'=>$categories,'form'=>$form,'showForm'=>true]);
         return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
    }


    public function getGraphData($id)
    {
        $graph = CompanyGraph::where('id', $id)->first();
        $graph_datasource = $graph->companyGraphDataSources()->first();
        $data = [];
        $jsonGraphData = [];
        if($graph_datasource->data_source_type == 'Csv')
        {
            $filePath = public_path('data.csv');
            $file = fopen($filePath, 'r');
            $graphdata = [];
            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                $graphdata[] = $data[0];
            }
            fclose($file);
            $jsonGraphData = $graphdata;
            return $jsonGraphData;
        }
        else if($graph_datasource->data_source_type == 'Api')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'FormInput')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'S3_file')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
    }

    public function showDocument($id,$docpage=null)
    {
        // TODO: Check if user has access to document
        $document = Book::find($id);
        $tabs=[
            ['name'=>'cs_summary','display'=>'Aperçu Generale', 'active'=>true],
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$document->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
        ];
        /*$pages = $document->pages()->get();
        foreach ($pages as $page){
            $tab = ['name'=>'doc_page','display'=>$page->name, 'model_id'=>$page->id];
            array_push($tabs,$tab);
        }
        */
        // TODO: Add access to user_books
        return view('dashboard.document', ['page'=>'doc_page','tabs'=>$tabs, 'document'=>$document]);
    }
    public function showCompany($id)
    {
        // TODO: Check if user has access to document
        $company = Company::find($id);
        $tabs=[
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$company->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
            ['name'=>'cs_documents','display'=>'Documents',]
            ,
        ];

        return view('dashboard.establishments', ['page'=>'doc_page','tabs'=>$tabs, 'company'=>$company]);
    }

    public function showForm($id,$input_id){
        // return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
        $form = Form::find($id);
        $categories = Category::all();
        //return view('frontpage.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'categories'=>$categories,'form'=>$form,'showForm'=>true]);
         return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
    }


    public function getGraphData($id)
    {
        $graph = CompanyGraph::where('id', $id)->first();
        $graph_datasource = $graph->companyGraphDataSources()->first();
        $data = [];
        $jsonGraphData = [];
        if($graph_datasource->data_source_type == 'Csv')
        {
            $filePath = public_path('data.csv');
            $file = fopen($filePath, 'r');
            $graphdata = [];
            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                $graphdata[] = $data[0];
            }
            fclose($file);
            $jsonGraphData = $graphdata;
            return $jsonGraphData;
        }
        else if($graph_datasource->data_source_type == 'Api')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'FormInput')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'S3_file')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
    }

    public function showDocument($id,$docpage=null)
    {
        // TODO: Check if user has access to document
        $document = Book::find($id);
        $tabs=[
            ['name'=>'cs_summary','display'=>'Aperçu Generale', 'active'=>true],
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$document->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
        ];
        /*$pages = $document->pages()->get();
        foreach ($pages as $page){
            $tab = ['name'=>'doc_page','display'=>$page->name, 'model_id'=>$page->id];
            array_push($tabs,$tab);
        }
        */
        // TODO: Add access to user_books
        return view('dashboard.document', ['page'=>'doc_page','tabs'=>$tabs, 'document'=>$document]);
    }
    public function showCompany($id)
    {
        // TODO: Check if user has access to document
        $company = Company::find($id);
        $tabs=[
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$company->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
            ['name'=>'cs_documents','display'=>'Documents',]
            ,
        ];

        return view('dashboard.establishments', ['page'=>'doc_page','tabs'=>$tabs, 'company'=>$company]);
    }

    public function showForm($id,$input_id){
        // return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
        $form = Form::find($id);
        $categories = Category::all();
        //return view('frontpage.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'categories'=>$categories,'form'=>$form,'showForm'=>true]);
         return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
    }


    public function getGraphData($id)
    {
        $graph = CompanyGraph::where('id', $id)->first();
        $graph_datasource = $graph->companyGraphDataSources()->first();
        $data = [];
        $jsonGraphData = [];
        if($graph_datasource->data_source_type == 'Csv')
        {
            $filePath = public_path('data.csv');
            $file = fopen($filePath, 'r');
            $graphdata = [];
            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                $graphdata[] = $data[0];
            }
            fclose($file);
            $jsonGraphData = $graphdata;
            return $jsonGraphData;
        }
        else if($graph_datasource->data_source_type == 'Api')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'FormInput')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'S3_file')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
    }

    public function showDocument($id,$docpage=null)
    {
        // TODO: Check if user has access to document
        $document = Book::find($id);
        $tabs=[
            ['name'=>'cs_summary','display'=>'Aperçu Generale', 'active'=>true],
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$document->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
        ];
        /*$pages = $document->pages()->get();
        foreach ($pages as $page){
            $tab = ['name'=>'doc_page','display'=>$page->name, 'model_id'=>$page->id];
            array_push($tabs,$tab);
        }
        */
        // TODO: Add access to user_books
        return view('dashboard.document', ['page'=>'doc_page','tabs'=>$tabs, 'document'=>$document]);
    }
    public function showCompany($id)
    {
        // TODO: Check if user has access to document
        $company = Company::find($id);
        $tabs=[
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$company->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
            ['name'=>'cs_documents','display'=>'Documents',]
            ,
        ];

        return view('dashboard.establishments', ['page'=>'doc_page','tabs'=>$tabs, 'company'=>$company]);
    }

    public function showForm($id,$input_id){
        // return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
        $form = Form::find($id);
        $categories = Category::all();
        //return view('frontpage.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'categories'=>$categories,'form'=>$form,'showForm'=>true]);
         return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
    }


    public function getGraphData($id)
    {
        $graph = CompanyGraph::where('id', $id)->first();
        $graph_datasource = $graph->companyGraphDataSources()->first();
        $data = [];
        $jsonGraphData = [];
        if($graph_datasource->data_source_type == 'Csv')
        {
            $filePath = public_path('data.csv');
            $file = fopen($filePath, 'r');
            $graphdata = [];
            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                $graphdata[] = $data[0];
            }
            fclose($file);
            $jsonGraphData = $graphdata;
            return $jsonGraphData;
        }
        else if($graph_datasource->data_source_type == 'Api')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'FormInput')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'S3_file')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
    }

    public function showDocument($id,$docpage=null)
    {
        // TODO: Check if user has access to document
        $document = Book::find($id);
        $tabs=[
            ['name'=>'cs_summary','display'=>'Aperçu Generale', 'active'=>true],
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$document->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
        ];
        /*$pages = $document->pages()->get();
        foreach ($pages as $page){
            $tab = ['name'=>'doc_page','display'=>$page->name, 'model_id'=>$page->id];
            array_push($tabs,$tab);
        }
        */
        // TODO: Add access to user_books
        return view('dashboard.document', ['page'=>'doc_page','tabs'=>$tabs, 'document'=>$document]);
    }
    public function showCompany($id)
    {
        // TODO: Check if user has access to document
        $company = Company::find($id);
        $tabs=[
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$company->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
            ['name'=>'cs_documents','display'=>'Documents',]
            ,
        ];

        return view('dashboard.establishments', ['page'=>'doc_page','tabs'=>$tabs, 'company'=>$company]);
    }

    public function showForm($id,$input_id){
        // return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
        $form = Form::find($id);
        $categories = Category::all();
        //return view('frontpage.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'categories'=>$categories,'form'=>$form,'showForm'=>true]);
         return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
    }


    public function getGraphData($id)
    {
        $graph = CompanyGraph::where('id', $id)->first();
        $graph_datasource = $graph->companyGraphDataSources()->first();
        $data = [];
        $jsonGraphData = [];
        if($graph_datasource->data_source_type == 'Csv')
        {
            $filePath = public_path('data.csv');
            $file = fopen($filePath, 'r');
            $graphdata = [];
            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                $graphdata[] = $data[0];
            }
            fclose($file);
            $jsonGraphData = $graphdata;
            return $jsonGraphData;
        }
        else if($graph_datasource->data_source_type == 'Api')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'FormInput')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'S3_file')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
    }

    public function showDocument($id,$docpage=null)
    {
        // TODO: Check if user has access to document
        $document = Book::find($id);
        $tabs=[
            ['name'=>'cs_summary','display'=>'Aperçu Generale', 'active'=>true],
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$document->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
        ];
        /*$pages = $document->pages()->get();
        foreach ($pages as $page){
            $tab = ['name'=>'doc_page','display'=>$page->name, 'model_id'=>$page->id];
            array_push($tabs,$tab);
        }
        */
        // TODO: Add access to user_books
        return view('dashboard.document', ['page'=>'doc_page','tabs'=>$tabs, 'document'=>$document]);
    }
    public function showCompany($id)
    {
        // TODO: Check if user has access to document
        $company = Company::find($id);
        $tabs=[
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$company->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
            ['name'=>'cs_documents','display'=>'Documents',]
            ,
        ];

        return view('dashboard.establishments', ['page'=>'doc_page','tabs'=>$tabs, 'company'=>$company]);
    }

    public function showForm($id,$input_id){
        // return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
        $form = Form::find($id);
        $categories = Category::all();
        //return view('frontpage.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'categories'=>$categories,'form'=>$form,'showForm'=>true]);
         return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
    }


    public function getGraphData($id)
    {
        $graph = CompanyGraph::where('id', $id)->first();
        $graph_datasource = $graph->companyGraphDataSources()->first();
        $data = [];
        $jsonGraphData = [];
        if($graph_datasource->data_source_type == 'Csv')
        {
            $filePath = public_path('data.csv');
            $file = fopen($filePath, 'r');
            $graphdata = [];
            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                $graphdata[] = $data[0];
            }
            fclose($file);
            $jsonGraphData = $graphdata;
            return $jsonGraphData;
        }
        else if($graph_datasource->data_source_type == 'Api')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'FormInput')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'S3_file')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
    }

    public function showDocument($id,$docpage=null)
    {
        // TODO: Check if user has access to document
        $document = Book::find($id);
        $tabs=[
            ['name'=>'cs_summary','display'=>'Aperçu Generale', 'active'=>true],
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$document->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
        ];
        /*$pages = $document->pages()->get();
        foreach ($pages as $page){
            $tab = ['name'=>'doc_page','display'=>$page->name, 'model_id'=>$page->id];
            array_push($tabs,$tab);
        }
        */
        // TODO: Add access to user_books
        return view('dashboard.document', ['page'=>'doc_page','tabs'=>$tabs, 'document'=>$document]);
    }
    public function showCompany($id)
    {
        // TODO: Check if user has access to document
        $company = Company::find($id);
        $tabs=[
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$company->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
            ['name'=>'cs_documents','display'=>'Documents',]
            ,
        ];

        return view('dashboard.establishments', ['page'=>'doc_page','tabs'=>$tabs, 'company'=>$company]);
    }

    public function showForm($id,$input_id){
        // return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
        $form = Form::find($id);
        $categories = Category::all();
        //return view('frontpage.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'categories'=>$categories,'form'=>$form,'showForm'=>true]);
         return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
    }


    public function getGraphData($id)
    {
        $graph = CompanyGraph::where('id', $id)->first();
        $graph_datasource = $graph->companyGraphDataSources()->first();
        $data = [];
        $jsonGraphData = [];
        if($graph_datasource->data_source_type == 'Csv')
        {
            $filePath = public_path('data.csv');
            $file = fopen($filePath, 'r');
            $graphdata = [];
            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                $graphdata[] = $data[0];
            }
            fclose($file);
            $jsonGraphData = $graphdata;
            return $jsonGraphData;
        }
        else if($graph_datasource->data_source_type == 'Api')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'FormInput')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'S3_file')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
    }

    public function showDocument($id,$docpage=null)
    {
        // TODO: Check if user has access to document
        $document = Book::find($id);
        $tabs=[
            ['name'=>'cs_summary','display'=>'Aperçu Generale', 'active'=>true],
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$document->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
        ];
        /*$pages = $document->pages()->get();
        foreach ($pages as $page){
            $tab = ['name'=>'doc_page','display'=>$page->name, 'model_id'=>$page->id];
            array_push($tabs,$tab);
        }
        */
        // TODO: Add access to user_books
        return view('dashboard.document', ['page'=>'doc_page','tabs'=>$tabs, 'document'=>$document]);
    }
    public function showCompany($id)
    {
        // TODO: Check if user has access to document
        $company = Company::find($id);
        $tabs=[
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$company->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
            ['name'=>'cs_documents','display'=>'Documents',]
            ,
        ];

        return view('dashboard.establishments', ['page'=>'doc_page','tabs'=>$tabs, 'company'=>$company]);
    }

    public function showForm($id,$input_id){
        // return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
        $form = Form::find($id);
        $categories = Category::all();
        //return view('frontpage.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'categories'=>$categories,'form'=>$form,'showForm'=>true]);
         return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
    }


    public function getGraphData($id)
    {
        $graph = CompanyGraph::where('id', $id)->first();
        $graph_datasource = $graph->companyGraphDataSources()->first();
        $data = [];
        $jsonGraphData = [];
        if($graph_datasource->data_source_type == 'Csv')
        {
            $filePath = public_path('data.csv');
            $file = fopen($filePath, 'r');
            $graphdata = [];
            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                $graphdata[] = $data[0];
            }
            fclose($file);
            $jsonGraphData = $graphdata;
            return $jsonGraphData;
        }
        else if($graph_datasource->data_source_type == 'Api')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'FormInput')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'S3_file')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
    }

    public function showDocument($id,$docpage=null)
    {
        // TODO: Check if user has access to document
        $document = Book::find($id);
        $tabs=[
            ['name'=>'cs_summary','display'=>'Aperçu Generale', 'active'=>true],
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$document->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
        ];
        /*$pages = $document->pages()->get();
        foreach ($pages as $page){
            $tab = ['name'=>'doc_page','display'=>$page->name, 'model_id'=>$page->id];
            array_push($tabs,$tab);
        }
        */
        // TODO: Add access to user_books
        return view('dashboard.document', ['page'=>'doc_page','tabs'=>$tabs, 'document'=>$document]);
    }
    public function showCompany($id)
    {
        // TODO: Check if user has access to document
        $company = Company::find($id);
        $tabs=[
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$company->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
            ['name'=>'cs_documents','display'=>'Documents',]
            ,
        ];

        return view('dashboard.establishments', ['page'=>'doc_page','tabs'=>$tabs, 'company'=>$company]);
    }

    public function showForm($id,$input_id){
        // return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
        $form = Form::find($id);
        $categories = Category::all();
        //return view('frontpage.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'categories'=>$categories,'form'=>$form,'showForm'=>true]);
         return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
    }


    public function getGraphData($id)
    {
        $graph = CompanyGraph::where('id', $id)->first();
        $graph_datasource = $graph->companyGraphDataSources()->first();
        $data = [];
        $jsonGraphData = [];
        if($graph_datasource->data_source_type == 'Csv')
        {
            $filePath = public_path('data.csv');
            $file = fopen($filePath, 'r');
            $graphdata = [];
            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                $graphdata[] = $data[0];
            }
            fclose($file);
            $jsonGraphData = $graphdata;
            return $jsonGraphData;
        }
        else if($graph_datasource->data_source_type == 'Api')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'FormInput')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'S3_file')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
    }

    public function showDocument($id,$docpage=null)
    {
        // TODO: Check if user has access to document
        $document = Book::find($id);
        $tabs=[
            ['name'=>'cs_summary','display'=>'Aperçu Generale', 'active'=>true],
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$document->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
        ];
        /*$pages = $document->pages()->get();
        foreach ($pages as $page){
            $tab = ['name'=>'doc_page','display'=>$page->name, 'model_id'=>$page->id];
            array_push($tabs,$tab);
        }
        */
        // TODO: Add access to user_books
        return view('dashboard.document', ['page'=>'doc_page','tabs'=>$tabs, 'document'=>$document]);
    }
    public function showCompany($id)
    {
        // TODO: Check if user has access to document
        $company = Company::find($id);
        $tabs=[
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$company->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
            ['name'=>'cs_documents','display'=>'Documents',]
            ,
        ];

        return view('dashboard.establishments', ['page'=>'doc_page','tabs'=>$tabs, 'company'=>$company]);
    }

    public function showForm($id,$input_id){
        // return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
        $form = Form::find($id);
        $categories = Category::all();
        //return view('frontpage.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'categories'=>$categories,'form'=>$form,'showForm'=>true]);
         return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
    }


    public function getGraphData($id)
    {
        $graph = CompanyGraph::where('id', $id)->first();
        $graph_datasource = $graph->companyGraphDataSources()->first();
        $data = [];
        $jsonGraphData = [];
        if($graph_datasource->data_source_type == 'Csv')
        {
            $filePath = public_path('data.csv');
            $file = fopen($filePath, 'r');
            $graphdata = [];
            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                $graphdata[] = $data[0];
            }
            fclose($file);
            $jsonGraphData = $graphdata;
            return $jsonGraphData;
        }
        else if($graph_datasource->data_source_type == 'Api')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'FormInput')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'S3_file')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
    }

    public function showDocument($id,$docpage=null)
    {
        // TODO: Check if user has access to document
        $document = Book::find($id);
        $tabs=[
            ['name'=>'cs_summary','display'=>'Aperçu Generale', 'active'=>true],
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$document->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
        ];
        /*$pages = $document->pages()->get();
        foreach ($pages as $page){
            $tab = ['name'=>'doc_page','display'=>$page->name, 'model_id'=>$page->id];
            array_push($tabs,$tab);
        }
        */
        // TODO: Add access to user_books
        return view('dashboard.document', ['page'=>'doc_page','tabs'=>$tabs, 'document'=>$document]);
    }
    public function showCompany($id)
    {
        // TODO: Check if user has access to document
        $company = Company::find($id);
        $tabs=[
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$company->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
            ['name'=>'cs_documents','display'=>'Documents',]
            ,
        ];

        return view('dashboard.establishments', ['page'=>'doc_page','tabs'=>$tabs, 'company'=>$company]);
    }

    public function showForm($id,$input_id){
        // return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
        $form = Form::find($id);
        $categories = Category::all();
        //return view('frontpage.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'categories'=>$categories,'form'=>$form,'showForm'=>true]);
         return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
    }


    public function getGraphData($id)
    {
        $graph = CompanyGraph::where('id', $id)->first();
        $graph_datasource = $graph->companyGraphDataSources()->first();
        $data = [];
        $jsonGraphData = [];
        if($graph_datasource->data_source_type == 'Csv')
        {
            $filePath = public_path('data.csv');
            $file = fopen($filePath, 'r');
            $graphdata = [];
            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                $graphdata[] = $data[0];
            }
            fclose($file);
            $jsonGraphData = $graphdata;
            return $jsonGraphData;
        }
        else if($graph_datasource->data_source_type == 'Api')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'FormInput')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'S3_file')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
    }

    public function showDocument($id,$docpage=null)
    {
        // TODO: Check if user has access to document
        $document = Book::find($id);
        $tabs=[
            ['name'=>'cs_summary','display'=>'Aperçu Generale', 'active'=>true],
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$document->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
        ];
        /*$pages = $document->pages()->get();
        foreach ($pages as $page){
            $tab = ['name'=>'doc_page','display'=>$page->name, 'model_id'=>$page->id];
            array_push($tabs,$tab);
        }
        */
        // TODO: Add access to user_books
        return view('dashboard.document', ['page'=>'doc_page','tabs'=>$tabs, 'document'=>$document]);
    }
    public function showCompany($id)
    {
        // TODO: Check if user has access to document
        $company = Company::find($id);
        $tabs=[
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$company->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
            ['name'=>'cs_documents','display'=>'Documents',]
            ,
        ];

        return view('dashboard.establishments', ['page'=>'doc_page','tabs'=>$tabs, 'company'=>$company]);
    }

    public function showForm($id,$input_id){
        // return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
        $form = Form::find($id);
        $categories = Category::all();
        //return view('frontpage.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'categories'=>$categories,'form'=>$form,'showForm'=>true]);
         return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
    }


    public function getGraphData($id)
    {
        $graph = CompanyGraph::where('id', $id)->first();
        $graph_datasource = $graph->companyGraphDataSources()->first();
        $data = [];
        $jsonGraphData = [];
        if($graph_datasource->data_source_type == 'Csv')
        {
            $filePath = public_path('data.csv');
            $file = fopen($filePath, 'r');
            $graphdata = [];
            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                $graphdata[] = $data[0];
            }
            fclose($file);
            $jsonGraphData = $graphdata;
            return $jsonGraphData;
        }
        else if($graph_datasource->data_source_type == 'Api')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'FormInput')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'S3_file')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
    }

    public function showDocument($id,$docpage=null)
    {
        // TODO: Check if user has access to document
        $document = Book::find($id);
        $tabs=[
            ['name'=>'cs_summary','display'=>'Aperçu Generale', 'active'=>true],
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$document->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
        ];
        /*$pages = $document->pages()->get();
        foreach ($pages as $page){
            $tab = ['name'=>'doc_page','display'=>$page->name, 'model_id'=>$page->id];
            array_push($tabs,$tab);
        }
        */
        // TODO: Add access to user_books
        return view('dashboard.document', ['page'=>'doc_page','tabs'=>$tabs, 'document'=>$document]);
    }
    public function showCompany($id)
    {
        // TODO: Check if user has access to document
        $company = Company::find($id);
        $tabs=[
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$company->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
            ['name'=>'cs_documents','display'=>'Documents',]
            ,
        ];

        return view('dashboard.establishments', ['page'=>'doc_page','tabs'=>$tabs, 'company'=>$company]);
    }

    public function showForm($id,$input_id){
        // return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
        $form = Form::find($id);
        $categories = Category::all();
        //return view('frontpage.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'categories'=>$categories,'form'=>$form,'showForm'=>true]);
         return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
    }


    public function getGraphData($id)
    {
        $graph = CompanyGraph::where('id', $id)->first();
        $graph_datasource = $graph->companyGraphDataSources()->first();
        $data = [];
        $jsonGraphData = [];
        if($graph_datasource->data_source_type == 'Csv')
        {
            $filePath = public_path('data.csv');
            $file = fopen($filePath, 'r');
            $graphdata = [];
            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                $graphdata[] = $data[0];
            }
            fclose($file);
            $jsonGraphData = $graphdata;
            return $jsonGraphData;
        }
        else if($graph_datasource->data_source_type == 'Api')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'FormInput')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'S3_file')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
    }

    public function showDocument($id,$docpage=null)
    {
        // TODO: Check if user has access to document
        $document = Book::find($id);
        $tabs=[
            ['name'=>'cs_summary','display'=>'Aperçu Generale', 'active'=>true],
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$document->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
        ];
        /*$pages = $document->pages()->get();
        foreach ($pages as $page){
            $tab = ['name'=>'doc_page','display'=>$page->name, 'model_id'=>$page->id];
            array_push($tabs,$tab);
        }
        */
        // TODO: Add access to user_books
        return view('dashboard.document', ['page'=>'doc_page','tabs'=>$tabs, 'document'=>$document]);
    }
    public function showCompany($id)
    {
        // TODO: Check if user has access to document
        $company = Company::find($id);
        $tabs=[
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$company->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
            ['name'=>'cs_documents','display'=>'Documents',]
            ,
        ];

        return view('dashboard.establishments', ['page'=>'doc_page','tabs'=>$tabs, 'company'=>$company]);
    }

    public function showForm($id,$input_id){
        // return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
        $form = Form::find($id);
        $categories = Category::all();
        //return view('frontpage.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'categories'=>$categories,'form'=>$form,'showForm'=>true]);
         return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
    }


    public function getGraphData($id)
    {
        $graph = CompanyGraph::where('id', $id)->first();
        $graph_datasource = $graph->companyGraphDataSources()->first();
        $data = [];
        $jsonGraphData = [];
        if($graph_datasource->data_source_type == 'Csv')
        {
            $filePath = public_path('data.csv');
            $file = fopen($filePath, 'r');
            $graphdata = [];
            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                $graphdata[] = $data[0];
            }
            fclose($file);
            $jsonGraphData = $graphdata;
            return $jsonGraphData;
        }
        else if($graph_datasource->data_source_type == 'Api')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'FormInput')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'S3_file')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
    }

    public function showDocument($id,$docpage=null)
    {
        // TODO: Check if user has access to document
        $document = Book::find($id);
        $tabs=[
            ['name'=>'cs_summary','display'=>'Aperçu Generale', 'active'=>true],
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$document->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
        ];
        /*$pages = $document->pages()->get();
        foreach ($pages as $page){
            $tab = ['name'=>'doc_page','display'=>$page->name, 'model_id'=>$page->id];
            array_push($tabs,$tab);
        }
        */
        // TODO: Add access to user_books
        return view('dashboard.document', ['page'=>'doc_page','tabs'=>$tabs, 'document'=>$document]);
    }
    public function showCompany($id)
    {
        // TODO: Check if user has access to document
        $company = Company::find($id);
        $tabs=[
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$company->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
            ['name'=>'cs_documents','display'=>'Documents',]
            ,
        ];

        return view('dashboard.establishments', ['page'=>'doc_page','tabs'=>$tabs, 'company'=>$company]);
    }

    public function showForm($id,$input_id){
        // return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
        $form = Form::find($id);
        $categories = Category::all();
        //return view('frontpage.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'categories'=>$categories,'form'=>$form,'showForm'=>true]);
         return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
    }


    public function getGraphData($id)
    {
        $graph = CompanyGraph::where('id', $id)->first();
        $graph_datasource = $graph->companyGraphDataSources()->first();
        $data = [];
        $jsonGraphData = [];
        if($graph_datasource->data_source_type == 'Csv')
        {
            $filePath = public_path('data.csv');
            $file = fopen($filePath, 'r');
            $graphdata = [];
            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                $graphdata[] = $data[0];
            }
            fclose($file);
            $jsonGraphData = $graphdata;
            return $jsonGraphData;
        }
        else if($graph_datasource->data_source_type == 'Api')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'FormInput')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'S3_file')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
    }

    public function showDocument($id,$docpage=null)
    {
        // TODO: Check if user has access to document
        $document = Book::find($id);
        $tabs=[
            ['name'=>'cs_summary','display'=>'Aperçu Generale', 'active'=>true],
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$document->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
        ];
        /*$pages = $document->pages()->get();
        foreach ($pages as $page){
            $tab = ['name'=>'doc_page','display'=>$page->name, 'model_id'=>$page->id];
            array_push($tabs,$tab);
        }
        */
        // TODO: Add access to user_books
        return view('dashboard.document', ['page'=>'doc_page','tabs'=>$tabs, 'document'=>$document]);
    }
    public function showCompany($id)
    {
        // TODO: Check if user has access to document
        $company = Company::find($id);
        $tabs=[
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$company->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
            ['name'=>'cs_documents','display'=>'Documents',]
            ,
        ];

        return view('dashboard.establishments', ['page'=>'doc_page','tabs'=>$tabs, 'company'=>$company]);
    }

    public function showForm($id,$input_id){
        // return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
        $form = Form::find($id);
        $categories = Category::all();
        //return view('frontpage.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'categories'=>$categories,'form'=>$form,'showForm'=>true]);
         return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
    }


    public function getGraphData($id)
    {
        $graph = CompanyGraph::where('id', $id)->first();
        $graph_datasource = $graph->companyGraphDataSources()->first();
        $data = [];
        $jsonGraphData = [];
        if($graph_datasource->data_source_type == 'Csv')
        {
            $filePath = public_path('data.csv');
            $file = fopen($filePath, 'r');
            $graphdata = [];
            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                $graphdata[] = $data[0];
            }
            fclose($file);
            $jsonGraphData = $graphdata;
            return $jsonGraphData;
        }
        else if($graph_datasource->data_source_type == 'Api')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'FormInput')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'S3_file')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
    }

    public function showDocument($id,$docpage=null)
    {
        // TODO: Check if user has access to document
        $document = Book::find($id);
        $tabs=[
            ['name'=>'cs_summary','display'=>'Aperçu Generale', 'active'=>true],
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$document->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
        ];
        /*$pages = $document->pages()->get();
        foreach ($pages as $page){
            $tab = ['name'=>'doc_page','display'=>$page->name, 'model_id'=>$page->id];
            array_push($tabs,$tab);
        }
        */
        // TODO: Add access to user_books
        return view('dashboard.document', ['page'=>'doc_page','tabs'=>$tabs, 'document'=>$document]);
    }
    public function showCompany($id)
    {
        // TODO: Check if user has access to document
        $company = Company::find($id);
        $tabs=[
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$company->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
            ['name'=>'cs_documents','display'=>'Documents',]
            ,
        ];

        return view('dashboard.establishments', ['page'=>'doc_page','tabs'=>$tabs, 'company'=>$company]);
    }

    public function showForm($id,$input_id){
        // return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
        $form = Form::find($id);
        $categories = Category::all();
        //return view('frontpage.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'categories'=>$categories,'form'=>$form,'showForm'=>true]);
         return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
    }


    public function getGraphData($id)
    {
        $graph = CompanyGraph::where('id', $id)->first();
        $graph_datasource = $graph->companyGraphDataSources()->first();
        $data = [];
        $jsonGraphData = [];
        if($graph_datasource->data_source_type == 'Csv')
        {
            $filePath = public_path('data.csv');
            $file = fopen($filePath, 'r');
            $graphdata = [];
            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                $graphdata[] = $data[0];
            }
            fclose($file);
            $jsonGraphData = $graphdata;
            return $jsonGraphData;
        }
        else if($graph_datasource->data_source_type == 'Api')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'FormInput')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'S3_file')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
    }

    public function showDocument($id,$docpage=null)
    {
        // TODO: Check if user has access to document
        $document = Book::find($id);
        $tabs=[
            ['name'=>'cs_summary','display'=>'Aperçu Generale', 'active'=>true],
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$document->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
        ];
        /*$pages = $document->pages()->get();
        foreach ($pages as $page){
            $tab = ['name'=>'doc_page','display'=>$page->name, 'model_id'=>$page->id];
            array_push($tabs,$tab);
        }
        */
        // TODO: Add access to user_books
        return view('dashboard.document', ['page'=>'doc_page','tabs'=>$tabs, 'document'=>$document]);
    }
    public function showCompany($id)
    {
        // TODO: Check if user has access to document
        $company = Company::find($id);
        $tabs=[
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$company->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
            ['name'=>'cs_documents','display'=>'Documents',]
            ,
        ];

        return view('dashboard.establishments', ['page'=>'doc_page','tabs'=>$tabs, 'company'=>$company]);
    }

    public function showForm($id,$input_id){
        // return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
        $form = Form::find($id);
        $categories = Category::all();
        //return view('frontpage.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'categories'=>$categories,'form'=>$form,'showForm'=>true]);
         return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
    }


    public function getGraphData($id)
    {
        $graph = CompanyGraph::where('id', $id)->first();
        $graph_datasource = $graph->companyGraphDataSources()->first();
        $data = [];
        $jsonGraphData = [];
        if($graph_datasource->data_source_type == 'Csv')
        {
            $filePath = public_path('data.csv');
            $file = fopen($filePath, 'r');
            $graphdata = [];
            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                $graphdata[] = $data[0];
            }
            fclose($file);
            $jsonGraphData = $graphdata;
            return $jsonGraphData;
        }
        else if($graph_datasource->data_source_type == 'Api')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'FormInput')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'S3_file')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
    }

    public function showDocument($id,$docpage=null)
    {
        // TODO: Check if user has access to document
        $document = Book::find($id);
        $tabs=[
            ['name'=>'cs_summary','display'=>'Aperçu Generale', 'active'=>true],
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$document->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
        ];
        /*$pages = $document->pages()->get();
        foreach ($pages as $page){
            $tab = ['name'=>'doc_page','display'=>$page->name, 'model_id'=>$page->id];
            array_push($tabs,$tab);
        }
        */
        // TODO: Add access to user_books
        return view('dashboard.document', ['page'=>'doc_page','tabs'=>$tabs, 'document'=>$document]);
    }
    public function showCompany($id)
    {
        // TODO: Check if user has access to document
        $company = Company::find($id);
        $tabs=[
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$company->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
            ['name'=>'cs_documents','display'=>'Documents',]
            ,
        ];

        return view('dashboard.establishments', ['page'=>'doc_page','tabs'=>$tabs, 'company'=>$company]);
    }

    public function showForm($id,$input_id){
        // return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
        $form = Form::find($id);
        $categories = Category::all();
        //return view('frontpage.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'categories'=>$categories,'form'=>$form,'showForm'=>true]);
         return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
    }


    public function getGraphData($id)
    {
        $graph = CompanyGraph::where('id', $id)->first();
        $graph_datasource = $graph->companyGraphDataSources()->first();
        $data = [];
        $jsonGraphData = [];
        if($graph_datasource->data_source_type == 'Csv')
        {
            $filePath = public_path('data.csv');
            $file = fopen($filePath, 'r');
            $graphdata = [];
            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                $graphdata[] = $data[0];
            }
            fclose($file);
            $jsonGraphData = $graphdata;
            return $jsonGraphData;
        }
        else if($graph_datasource->data_source_type == 'Api')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'FormInput')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'S3_file')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
    }

    public function showDocument($id,$docpage=null)
    {
        // TODO: Check if user has access to document
        $document = Book::find($id);
        $tabs=[
            ['name'=>'cs_summary','display'=>'Aperçu Generale', 'active'=>true],
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$document->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
        ];
        /*$pages = $document->pages()->get();
        foreach ($pages as $page){
            $tab = ['name'=>'doc_page','display'=>$page->name, 'model_id'=>$page->id];
            array_push($tabs,$tab);
        }
        */
        // TODO: Add access to user_books
        return view('dashboard.document', ['page'=>'doc_page','tabs'=>$tabs, 'document'=>$document]);
    }
    public function showCompany($id)
    {
        // TODO: Check if user has access to document
        $company = Company::find($id);
        $tabs=[
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$company->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
            ['name'=>'cs_documents','display'=>'Documents',]
            ,
        ];

        return view('dashboard.establishments', ['page'=>'doc_page','tabs'=>$tabs, 'company'=>$company]);
    }

    public function showForm($id,$input_id){
        // return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
        $form = Form::find($id);
        $categories = Category::all();
        //return view('frontpage.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'categories'=>$categories,'form'=>$form,'showForm'=>true]);
         return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
    }


    public function getGraphData($id)
    {
        $graph = CompanyGraph::where('id', $id)->first();
        $graph_datasource = $graph->companyGraphDataSources()->first();
        $data = [];
        $jsonGraphData = [];
        if($graph_datasource->data_source_type == 'Csv')
        {
            $filePath = public_path('data.csv');
            $file = fopen($filePath, 'r');
            $graphdata = [];
            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                $graphdata[] = $data[0];
            }
            fclose($file);
            $jsonGraphData = $graphdata;
            return $jsonGraphData;
        }
        else if($graph_datasource->data_source_type == 'Api')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'FormInput')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'S3_file')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
    }

    public function showDocument($id,$docpage=null)
    {
        // TODO: Check if user has access to document
        $document = Book::find($id);
        $tabs=[
            ['name'=>'cs_summary','display'=>'Aperçu Generale', 'active'=>true],
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$document->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
        ];
        /*$pages = $document->pages()->get();
        foreach ($pages as $page){
            $tab = ['name'=>'doc_page','display'=>$page->name, 'model_id'=>$page->id];
            array_push($tabs,$tab);
        }
        */
        // TODO: Add access to user_books
        return view('dashboard.document', ['page'=>'doc_page','tabs'=>$tabs, 'document'=>$document]);
    }
    public function showCompany($id)
    {
        // TODO: Check if user has access to document
        $company = Company::find($id);
        $tabs=[
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$company->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
            ['name'=>'cs_documents','display'=>'Documents',]
            ,
        ];

        return view('dashboard.establishments', ['page'=>'doc_page','tabs'=>$tabs, 'company'=>$company]);
    }

    public function showForm($id,$input_id){
        // return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
        $form = Form::find($id);
        $categories = Category::all();
        //return view('frontpage.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'categories'=>$categories,'form'=>$form,'showForm'=>true]);
         return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
    }


    public function getGraphData($id)
    {
        $graph = CompanyGraph::where('id', $id)->first();
        $graph_datasource = $graph->companyGraphDataSources()->first();
        $data = [];
        $jsonGraphData = [];
        if($graph_datasource->data_source_type == 'Csv')
        {
            $filePath = public_path('data.csv');
            $file = fopen($filePath, 'r');
            $graphdata = [];
            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                $graphdata[] = $data[0];
            }
            fclose($file);
            $jsonGraphData = $graphdata;
            return $jsonGraphData;
        }
        else if($graph_datasource->data_source_type == 'Api')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'FormInput')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'S3_file')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
    }

    public function showDocument($id,$docpage=null)
    {
        // TODO: Check if user has access to document
        $document = Book::find($id);
        $tabs=[
            ['name'=>'cs_summary','display'=>'Aperçu Generale', 'active'=>true],
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$document->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
        ];
        /*$pages = $document->pages()->get();
        foreach ($pages as $page){
            $tab = ['name'=>'doc_page','display'=>$page->name, 'model_id'=>$page->id];
            array_push($tabs,$tab);
        }
        */
        // TODO: Add access to user_books
        return view('dashboard.document', ['page'=>'doc_page','tabs'=>$tabs, 'document'=>$document]);
    }
    public function showCompany($id)
    {
        // TODO: Check if user has access to document
        $company = Company::find($id);
        $tabs=[
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$company->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
            ['name'=>'cs_documents','display'=>'Documents',]
            ,
        ];

        return view('dashboard.establishments', ['page'=>'doc_page','tabs'=>$tabs, 'company'=>$company]);
    }

    public function showForm($id,$input_id){
        // return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
        $form = Form::find($id);
        $categories = Category::all();
        //return view('frontpage.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'categories'=>$categories,'form'=>$form,'showForm'=>true]);
         return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
    }


    public function getGraphData($id)
    {
        $graph = CompanyGraph::where('id', $id)->first();
        $graph_datasource = $graph->companyGraphDataSources()->first();
        $data = [];
        $jsonGraphData = [];
        if($graph_datasource->data_source_type == 'Csv')
        {
            $filePath = public_path('data.csv');
            $file = fopen($filePath, 'r');
            $graphdata = [];
            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                $graphdata[] = $data[0];
            }
            fclose($file);
            $jsonGraphData = $graphdata;
            return $jsonGraphData;
        }
        else if($graph_datasource->data_source_type == 'Api')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'FormInput')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'S3_file')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
    }

    public function showDocument($id,$docpage=null)
    {
        // TODO: Check if user has access to document
        $document = Book::find($id);
        $tabs=[
            ['name'=>'cs_summary','display'=>'Aperçu Generale', 'active'=>true],
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$document->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
        ];
        /*$pages = $document->pages()->get();
        foreach ($pages as $page){
            $tab = ['name'=>'doc_page','display'=>$page->name, 'model_id'=>$page->id];
            array_push($tabs,$tab);
        }
        */
        // TODO: Add access to user_books
        return view('dashboard.document', ['page'=>'doc_page','tabs'=>$tabs, 'document'=>$document]);
    }
    public function showCompany($id)
    {
        // TODO: Check if user has access to document
        $company = Company::find($id);
        $tabs=[
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$company->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
            ['name'=>'cs_documents','display'=>'Documents',]
            ,
        ];

        return view('dashboard.establishments', ['page'=>'doc_page','tabs'=>$tabs, 'company'=>$company]);
    }

    public function showForm($id,$input_id){
        // return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
        $form = Form::find($id);
        $categories = Category::all();
        //return view('frontpage.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'categories'=>$categories,'form'=>$form,'showForm'=>true]);
         return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
    }


    public function getGraphData($id)
    {
        $graph = CompanyGraph::where('id', $id)->first();
        $graph_datasource = $graph->companyGraphDataSources()->first();
        $data = [];
        $jsonGraphData = [];
        if($graph_datasource->data_source_type == 'Csv')
        {
            $filePath = public_path('data.csv');
            $file = fopen($filePath, 'r');
            $graphdata = [];
            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                $graphdata[] = $data[0];
            }
            fclose($file);
            $jsonGraphData = $graphdata;
            return $jsonGraphData;
        }
        else if($graph_datasource->data_source_type == 'Api')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'FormInput')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'S3_file')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
    }

    public function showDocument($id,$docpage=null)
    {
        // TODO: Check if user has access to document
        $document = Book::find($id);
        $tabs=[
            ['name'=>'cs_summary','display'=>'Aperçu Generale', 'active'=>true],
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$document->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
        ];
        /*$pages = $document->pages()->get();
        foreach ($pages as $page){
            $tab = ['name'=>'doc_page','display'=>$page->name, 'model_id'=>$page->id];
            array_push($tabs,$tab);
        }
        */
        // TODO: Add access to user_books
        return view('dashboard.document', ['page'=>'doc_page','tabs'=>$tabs, 'document'=>$document]);
    }
    public function showCompany($id)
    {
        // TODO: Check if user has access to document
        $company = Company::find($id);
        $tabs=[
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$company->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
            ['name'=>'cs_documents','display'=>'Documents',]
            ,
        ];

        return view('dashboard.establishments', ['page'=>'doc_page','tabs'=>$tabs, 'company'=>$company]);
    }

    public function showForm($id,$input_id){
        // return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
        $form = Form::find($id);
        $categories = Category::all();
        //return view('frontpage.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'categories'=>$categories,'form'=>$form,'showForm'=>true]);
         return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
    }


    public function getGraphData($id)
    {
        $graph = CompanyGraph::where('id', $id)->first();
        $graph_datasource = $graph->companyGraphDataSources()->first();
        $data = [];
        $jsonGraphData = [];
        if($graph_datasource->data_source_type == 'Csv')
        {
            $filePath = public_path('data.csv');
            $file = fopen($filePath, 'r');
            $graphdata = [];
            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                $graphdata[] = $data[0];
            }
            fclose($file);
            $jsonGraphData = $graphdata;
            return $jsonGraphData;
        }
        else if($graph_datasource->data_source_type == 'Api')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'FormInput')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'S3_file')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
    }

    public function showDocument($id,$docpage=null)
    {
        // TODO: Check if user has access to document
        $document = Book::find($id);
        $tabs=[
            ['name'=>'cs_summary','display'=>'Aperçu Generale', 'active'=>true],
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$document->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
        ];
        /*$pages = $document->pages()->get();
        foreach ($pages as $page){
            $tab = ['name'=>'doc_page','display'=>$page->name, 'model_id'=>$page->id];
            array_push($tabs,$tab);
        }
        */
        // TODO: Add access to user_books
        return view('dashboard.document', ['page'=>'doc_page','tabs'=>$tabs, 'document'=>$document]);
    }
    public function showCompany($id)
    {
        // TODO: Check if user has access to document
        $company = Company::find($id);
        $tabs=[
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$company->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
            ['name'=>'cs_documents','display'=>'Documents',]
            ,
        ];

        return view('dashboard.establishments', ['page'=>'doc_page','tabs'=>$tabs, 'company'=>$company]);
    }

    public function showForm($id,$input_id){
        // return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
        $form = Form::find($id);
        $categories = Category::all();
        //return view('frontpage.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'categories'=>$categories,'form'=>$form,'showForm'=>true]);
         return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
    }


    public function getGraphData($id)
    {
        $graph = CompanyGraph::where('id', $id)->first();
        $graph_datasource = $graph->companyGraphDataSources()->first();
        $data = [];
        $jsonGraphData = [];
        if($graph_datasource->data_source_type == 'Csv')
        {
            $filePath = public_path('data.csv');
            $file = fopen($filePath, 'r');
            $graphdata = [];
            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                $graphdata[] = $data[0];
            }
            fclose($file);
            $jsonGraphData = $graphdata;
            return $jsonGraphData;
        }
        else if($graph_datasource->data_source_type == 'Api')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'FormInput')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'S3_file')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
    }

    public function showDocument($id,$docpage=null)
    {
        // TODO: Check if user has access to document
        $document = Book::find($id);
        $tabs=[
            ['name'=>'cs_summary','display'=>'Aperçu Generale', 'active'=>true],
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$document->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
        ];
        /*$pages = $document->pages()->get();
        foreach ($pages as $page){
            $tab = ['name'=>'doc_page','display'=>$page->name, 'model_id'=>$page->id];
            array_push($tabs,$tab);
        }
        */
        // TODO: Add access to user_books
        return view('dashboard.document', ['page'=>'doc_page','tabs'=>$tabs, 'document'=>$document]);
    }
    public function showCompany($id)
    {
        // TODO: Check if user has access to document
        $company = Company::find($id);
        $tabs=[
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$company->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
            ['name'=>'cs_documents','display'=>'Documents',]
            ,
        ];

        return view('dashboard.establishments', ['page'=>'doc_page','tabs'=>$tabs, 'company'=>$company]);
    }

    public function showForm($id,$input_id){
        // return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
        $form = Form::find($id);
        $categories = Category::all();
        //return view('frontpage.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'categories'=>$categories,'form'=>$form,'showForm'=>true]);
         return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
    }


    public function getGraphData($id)
    {
        $graph = CompanyGraph::where('id', $id)->first();
        $graph_datasource = $graph->companyGraphDataSources()->first();
        $data = [];
        $jsonGraphData = [];
        if($graph_datasource->data_source_type == 'Csv')
        {
            $filePath = public_path('data.csv');
            $file = fopen($filePath, 'r');
            $graphdata = [];
            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                $graphdata[] = $data[0];
            }
            fclose($file);
            $jsonGraphData = $graphdata;
            return $jsonGraphData;
        }
        else if($graph_datasource->data_source_type == 'Api')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'FormInput')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'S3_file')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
    }

    public function showDocument($id,$docpage=null)
    {
        // TODO: Check if user has access to document
        $document = Book::find($id);
        $tabs=[
            ['name'=>'cs_summary','display'=>'Aperçu Generale', 'active'=>true],
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$document->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
        ];
        /*$pages = $document->pages()->get();
        foreach ($pages as $page){
            $tab = ['name'=>'doc_page','display'=>$page->name, 'model_id'=>$page->id];
            array_push($tabs,$tab);
        }
        */
        // TODO: Add access to user_books
        return view('dashboard.document', ['page'=>'doc_page','tabs'=>$tabs, 'document'=>$document]);
    }
    public function showCompany($id)
    {
        // TODO: Check if user has access to document
        $company = Company::find($id);
        $tabs=[
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$company->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
            ['name'=>'cs_documents','display'=>'Documents',]
            ,
        ];

        return view('dashboard.establishments', ['page'=>'doc_page','tabs'=>$tabs, 'company'=>$company]);
    }

    public function showForm($id,$input_id){
        // return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
        $form = Form::find($id);
        $categories = Category::all();
        //return view('frontpage.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'categories'=>$categories,'form'=>$form,'showForm'=>true]);
         return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
    }


    public function getGraphData($id)
    {
        $graph = CompanyGraph::where('id', $id)->first();
        $graph_datasource = $graph->companyGraphDataSources()->first();
        $data = [];
        $jsonGraphData = [];
        if($graph_datasource->data_source_type == 'Csv')
        {
            $filePath = public_path('data.csv');
            $file = fopen($filePath, 'r');
            $graphdata = [];
            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                $graphdata[] = $data[0];
            }
            fclose($file);
            $jsonGraphData = $graphdata;
            return $jsonGraphData;
        }
        else if($graph_datasource->data_source_type == 'Api')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'FormInput')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'S3_file')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
    }

    public function showDocument($id,$docpage=null)
    {
        // TODO: Check if user has access to document
        $document = Book::find($id);
        $tabs=[
            ['name'=>'cs_summary','display'=>'Aperçu Generale', 'active'=>true],
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$document->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
        ];
        /*$pages = $document->pages()->get();
        foreach ($pages as $page){
            $tab = ['name'=>'doc_page','display'=>$page->name, 'model_id'=>$page->id];
            array_push($tabs,$tab);
        }
        */
        // TODO: Add access to user_books
        return view('dashboard.document', ['page'=>'doc_page','tabs'=>$tabs, 'document'=>$document]);
    }
    public function showCompany($id)
    {
        // TODO: Check if user has access to document
        $company = Company::find($id);
        $tabs=[
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$company->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
            ['name'=>'cs_documents','display'=>'Documents',]
            ,
        ];

        return view('dashboard.establishments', ['page'=>'doc_page','tabs'=>$tabs, 'company'=>$company]);
    }

    public function showForm($id,$input_id){
        // return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
        $form = Form::find($id);
        $categories = Category::all();
        //return view('frontpage.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'categories'=>$categories,'form'=>$form,'showForm'=>true]);
         return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
    }


    public function getGraphData($id)
    {
        $graph = CompanyGraph::where('id', $id)->first();
        $graph_datasource = $graph->companyGraphDataSources()->first();
        $data = [];
        $jsonGraphData = [];
        if($graph_datasource->data_source_type == 'Csv')
        {
            $filePath = public_path('data.csv');
            $file = fopen($filePath, 'r');
            $graphdata = [];
            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                $graphdata[] = $data[0];
            }
            fclose($file);
            $jsonGraphData = $graphdata;
            return $jsonGraphData;
        }
        else if($graph_datasource->data_source_type == 'Api')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'FormInput')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'S3_file')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
    }


    public function showDocument($id,$docpage=null)
    {
        // TODO: Check if user has access to document
        $document = Book::find($id);
        $tabs=[
            ['name'=>'cs_summary','display'=>'Aperçu Generale', 'active'=>true],
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$document->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
        ];
        /*$pages = $document->pages()->get();
        foreach ($pages as $page){
            $tab = ['name'=>'doc_page','display'=>$page->name, 'model_id'=>$page->id];
            array_push($tabs,$tab);
        }
        */
        // TODO: Add access to user_books
        return view('dashboard.document', ['page'=>'doc_page','tabs'=>$tabs, 'document'=>$document]);
    }
    public function showCompany($id)
    {
        // TODO: Check if user has access to document
        $company = Company::find($id);
        $tabs=[
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$company->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
            ['name'=>'cs_documents','display'=>'Documents',]
            ,
        ];

        return view('dashboard.establishments', ['page'=>'doc_page','tabs'=>$tabs, 'company'=>$company]);
    }

    public function showForm($id,$input_id){
        // return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
        $form = Form::find($id);
        $categories = Category::all();
        //return view('frontpage.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'categories'=>$categories,'form'=>$form,'showForm'=>true]);
         return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
    }


    public function getGraphData($id)
    {
        $graph = CompanyGraph::where('id', $id)->first();
        $graph_datasource = $graph->companyGraphDataSources()->first();
        $data = [];
        $jsonGraphData = [];
        if($graph_datasource->data_source_type == 'Csv')
        {
            $filePath = public_path('data.csv');
            $file = fopen($filePath, 'r');
            $graphdata = [];
            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                $graphdata[] = $data[0];
            }
            fclose($file);
            $jsonGraphData = $graphdata;
            return $jsonGraphData;
        }
        else if($graph_datasource->data_source_type == 'Api')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'FormInput')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'S3_file')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
    }

    public function showDocument($id,$docpage=null)
    {
        // TODO: Check if user has access to document
        $document = Book::find($id);
        $tabs=[
            ['name'=>'cs_summary','display'=>'Aperçu Generale', 'active'=>true],
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$document->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
        ];
        /*$pages = $document->pages()->get();
        foreach ($pages as $page){
            $tab = ['name'=>'doc_page','display'=>$page->name, 'model_id'=>$page->id];
            array_push($tabs,$tab);
        }
        */
        // TODO: Add access to user_books
        return view('dashboard.document', ['page'=>'doc_page','tabs'=>$tabs, 'document'=>$document]);
    }
    public function showCompany($id)
    {
        // TODO: Check if user has access to document
        $company = Company::find($id);
        $tabs=[
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$company->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
            ['name'=>'cs_documents','display'=>'Documents',]
            ,
        ];

        return view('dashboard.establishments', ['page'=>'doc_page','tabs'=>$tabs, 'company'=>$company]);
    }

    public function showForm($id,$input_id){
        // return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
        $form = Form::find($id);
        $categories = Category::all();
        //return view('frontpage.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'categories'=>$categories,'form'=>$form,'showForm'=>true]);
         return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
    }


    public function getGraphData($id)
    {
        $graph = CompanyGraph::where('id', $id)->first();
        $graph_datasource = $graph->companyGraphDataSources()->first();
        $data = [];
        $jsonGraphData = [];
        if($graph_datasource->data_source_type == 'Csv')
        {
            $filePath = public_path('data.csv');
            $file = fopen($filePath, 'r');
            $graphdata = [];
            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                $graphdata[] = $data[0];
            }
            fclose($file);
            $jsonGraphData = $graphdata;
            return $jsonGraphData;
        }
        else if($graph_datasource->data_source_type == 'Api')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'FormInput')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'S3_file')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
    }

    public function showDocument($id,$docpage=null)
    {
        // TODO: Check if user has access to document
        $document = Book::find($id);
        $tabs=[
            ['name'=>'cs_summary','display'=>'Aperçu Generale', 'active'=>true],
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$document->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
        ];
        /*$pages = $document->pages()->get();
        foreach ($pages as $page){
            $tab = ['name'=>'doc_page','display'=>$page->name, 'model_id'=>$page->id];
            array_push($tabs,$tab);
        }
        */
        // TODO: Add access to user_books
        return view('dashboard.document', ['page'=>'doc_page','tabs'=>$tabs, 'document'=>$document]);
    }
    public function showCompany($id)
    {
        // TODO: Check if user has access to document
        $company = Company::find($id);
        $tabs=[
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$company->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
            ['name'=>'cs_documents','display'=>'Documents',]
            ,
        ];

        return view('dashboard.establishments', ['page'=>'doc_page','tabs'=>$tabs, 'company'=>$company]);
    }

    public function showForm($id,$input_id){
        // return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
        $form = Form::find($id);
        $categories = Category::all();
        //return view('frontpage.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'categories'=>$categories,'form'=>$form,'showForm'=>true]);
         return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
    }


    public function getGraphData($id)
    {
        $graph = CompanyGraph::where('id', $id)->first();
        $graph_datasource = $graph->companyGraphDataSources()->first();
        $data = [];
        $jsonGraphData = [];
        if($graph_datasource->data_source_type == 'Csv')
        {
            $filePath = public_path('data.csv');
            $file = fopen($filePath, 'r');
            $graphdata = [];
            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                $graphdata[] = $data[0];
            }
            fclose($file);
            $jsonGraphData = $graphdata;
            return $jsonGraphData;
        }
        else if($graph_datasource->data_source_type == 'Api')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'FormInput')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'S3_file')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
    }

    public function showDocument($id,$docpage=null)
    {
        // TODO: Check if user has access to document
        $document = Book::find($id);
        $tabs=[
            ['name'=>'cs_summary','display'=>'Aperçu Generale', 'active'=>true],
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$document->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
        ];
        /*$pages = $document->pages()->get();
        foreach ($pages as $page){
            $tab = ['name'=>'doc_page','display'=>$page->name, 'model_id'=>$page->id];
            array_push($tabs,$tab);
        }
        */
        // TODO: Add access to user_books
        return view('dashboard.document', ['page'=>'doc_page','tabs'=>$tabs, 'document'=>$document]);
    }
    public function showCompany($id)
    {
        // TODO: Check if user has access to document
        $company = Company::find($id);
        $tabs=[
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$company->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
            ['name'=>'cs_documents','display'=>'Documents',]
            ,
        ];

        return view('dashboard.establishments', ['page'=>'doc_page','tabs'=>$tabs, 'company'=>$company]);
    }

    public function showForm($id,$input_id){
        // return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
        $form = Form::find($id);
        $categories = Category::all();
        //return view('frontpage.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'categories'=>$categories,'form'=>$form,'showForm'=>true]);
         return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
    }


    public function getGraphData($id)
    {
        $graph = CompanyGraph::where('id', $id)->first();
        $graph_datasource = $graph->companyGraphDataSources()->first();
        $data = [];
        $jsonGraphData = [];
        if($graph_datasource->data_source_type == 'Csv')
        {
            $filePath = public_path('data.csv');
            $file = fopen($filePath, 'r');
            $graphdata = [];
            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                $graphdata[] = $data[0];
            }
            fclose($file);
            $jsonGraphData = $graphdata;
            return $jsonGraphData;
        }
        else if($graph_datasource->data_source_type == 'Api')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'FormInput')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'S3_file')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
    }

    public function showDocument($id,$docpage=null)
    {
        // TODO: Check if user has access to document
        $document = Book::find($id);
        $tabs=[
            ['name'=>'cs_summary','display'=>'Aperçu Generale', 'active'=>true],
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$document->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
        ];
        /*$pages = $document->pages()->get();
        foreach ($pages as $page){
            $tab = ['name'=>'doc_page','display'=>$page->name, 'model_id'=>$page->id];
            array_push($tabs,$tab);
        }
        */
        // TODO: Add access to user_books
        return view('dashboard.document', ['page'=>'doc_page','tabs'=>$tabs, 'document'=>$document]);
    }
    public function showCompany($id)
    {
        // TODO: Check if user has access to document
        $company = Company::find($id);
        $tabs=[
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$company->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
            ['name'=>'cs_documents','display'=>'Documents',]
            ,
        ];

        return view('dashboard.establishments', ['page'=>'doc_page','tabs'=>$tabs, 'company'=>$company]);
    }

    public function showForm($id,$input_id){
        // return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
        $form = Form::find($id);
        $categories = Category::all();
        //return view('frontpage.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'categories'=>$categories,'form'=>$form,'showForm'=>true]);
         return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
    }


    public function getGraphData($id)
    {
        $graph = CompanyGraph::where('id', $id)->first();
        $graph_datasource = $graph->companyGraphDataSources()->first();
        $data = [];
        $jsonGraphData = [];
        if($graph_datasource->data_source_type == 'Csv')
        {
            $filePath = public_path('data.csv');
            $file = fopen($filePath, 'r');
            $graphdata = [];
            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                $graphdata[] = $data[0];
            }
            fclose($file);
            $jsonGraphData = $graphdata;
            return $jsonGraphData;
        }
        else if($graph_datasource->data_source_type == 'Api')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'FormInput')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'S3_file')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
    }

    public function showDocument($id,$docpage=null)
    {
        // TODO: Check if user has access to document
        $document = Book::find($id);
        $tabs=[
            ['name'=>'cs_summary','display'=>'Aperçu Generale', 'active'=>true],
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$document->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
        ];
        /*$pages = $document->pages()->get();
        foreach ($pages as $page){
            $tab = ['name'=>'doc_page','display'=>$page->name, 'model_id'=>$page->id];
            array_push($tabs,$tab);
        }
        */
        // TODO: Add access to user_books
        return view('dashboard.document', ['page'=>'doc_page','tabs'=>$tabs, 'document'=>$document]);
    }
    public function showCompany($id)
    {
        // TODO: Check if user has access to document
        $company = Company::find($id);
        $tabs=[
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$company->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
            ['name'=>'cs_documents','display'=>'Documents',]
            ,
        ];

        return view('dashboard.establishments', ['page'=>'doc_page','tabs'=>$tabs, 'company'=>$company]);
    }

    public function showForm($id,$input_id){
        // return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
        $form = Form::find($id);
        $categories = Category::all();
        //return view('frontpage.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'categories'=>$categories,'form'=>$form,'showForm'=>true]);
         return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
    }


    public function getGraphData($id)
    {
        $graph = CompanyGraph::where('id', $id)->first();
        $graph_datasource = $graph->companyGraphDataSources()->first();
        $data = [];
        $jsonGraphData = [];
        if($graph_datasource->data_source_type == 'Csv')
        {
            $filePath = public_path('data.csv');
            $file = fopen($filePath, 'r');
            $graphdata = [];
            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                $graphdata[] = $data[0];
            }
            fclose($file);
            $jsonGraphData = $graphdata;
            return $jsonGraphData;
        }
        else if($graph_datasource->data_source_type == 'Api')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'FormInput')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'S3_file')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
    }

    public function showDocument($id,$docpage=null)
    {
        // TODO: Check if user has access to document
        $document = Book::find($id);
        $tabs=[
            ['name'=>'cs_summary','display'=>'Aperçu Generale', 'active'=>true],
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$document->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
        ];
        /*$pages = $document->pages()->get();
        foreach ($pages as $page){
            $tab = ['name'=>'doc_page','display'=>$page->name, 'model_id'=>$page->id];
            array_push($tabs,$tab);
        }
        */
        // TODO: Add access to user_books
        return view('dashboard.document', ['page'=>'doc_page','tabs'=>$tabs, 'document'=>$document]);
    }
    public function showCompany($id)
    {
        // TODO: Check if user has access to document
        $company = Company::find($id);
        $tabs=[
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$company->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
            ['name'=>'cs_documents','display'=>'Documents',]
            ,
        ];

        return view('dashboard.establishments', ['page'=>'doc_page','tabs'=>$tabs, 'company'=>$company]);
    }

    public function showForm($id,$input_id){
        // return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
        $form = Form::find($id);
        $categories = Category::all();
        //return view('frontpage.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'categories'=>$categories,'form'=>$form,'showForm'=>true]);
         return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
    }


    public function getGraphData($id)
    {
        $graph = CompanyGraph::where('id', $id)->first();
        $graph_datasource = $graph->companyGraphDataSources()->first();
        $data = [];
        $jsonGraphData = [];
        if($graph_datasource->data_source_type == 'Csv')
        {
            $filePath = public_path('data.csv');
            $file = fopen($filePath, 'r');
            $graphdata = [];
            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                $graphdata[] = $data[0];
            }
            fclose($file);
            $jsonGraphData = $graphdata;
            return $jsonGraphData;
        }
        else if($graph_datasource->data_source_type == 'Api')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'FormInput')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'S3_file')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
    }

    public function showDocument($id,$docpage=null)
    {
        // TODO: Check if user has access to document
        $document = Book::find($id);
        $tabs=[
            ['name'=>'cs_summary','display'=>'Aperçu Generale', 'active'=>true],
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$document->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
        ];
        /*$pages = $document->pages()->get();
        foreach ($pages as $page){
            $tab = ['name'=>'doc_page','display'=>$page->name, 'model_id'=>$page->id];
            array_push($tabs,$tab);
        }
        */
        // TODO: Add access to user_books
        return view('dashboard.document', ['page'=>'doc_page','tabs'=>$tabs, 'document'=>$document]);
    }
    public function showCompany($id)
    {
        // TODO: Check if user has access to document
        $company = Company::find($id);
        $tabs=[
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$company->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
            ['name'=>'cs_documents','display'=>'Documents',]
            ,
        ];

        return view('dashboard.establishments', ['page'=>'doc_page','tabs'=>$tabs, 'company'=>$company]);
    }

    public function showForm($id,$input_id){
        // return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
        $form = Form::find($id);
        $categories = Category::all();
        //return view('frontpage.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'categories'=>$categories,'form'=>$form,'showForm'=>true]);
         return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
    }


    public function getGraphData($id)
    {
        $graph = CompanyGraph::where('id', $id)->first();
        $graph_datasource = $graph->companyGraphDataSources()->first();
        $data = [];
        $jsonGraphData = [];
        if($graph_datasource->data_source_type == 'Csv')
        {
            $filePath = public_path('data.csv');
            $file = fopen($filePath, 'r');
            $graphdata = [];
            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                $graphdata[] = $data[0];
            }
            fclose($file);
            $jsonGraphData = $graphdata;
            return $jsonGraphData;
        }
        else if($graph_datasource->data_source_type == 'Api')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'FormInput')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'S3_file')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
    }

    public function showDocument($id,$docpage=null)
    {
        // TODO: Check if user has access to document
        $document = Book::find($id);
        $tabs=[
            ['name'=>'cs_summary','display'=>'Aperçu Generale', 'active'=>true],
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$document->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
        ];
        /*$pages = $document->pages()->get();
        foreach ($pages as $page){
            $tab = ['name'=>'doc_page','display'=>$page->name, 'model_id'=>$page->id];
            array_push($tabs,$tab);
        }
        */
        // TODO: Add access to user_books
        return view('dashboard.document', ['page'=>'doc_page','tabs'=>$tabs, 'document'=>$document]);
    }
    public function showCompany($id)
    {
        // TODO: Check if user has access to document
        $company = Company::find($id);
        $tabs=[
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$company->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
            ['name'=>'cs_documents','display'=>'Documents',]
            ,
        ];

        return view('dashboard.establishments', ['page'=>'doc_page','tabs'=>$tabs, 'company'=>$company]);
    }

    public function showForm($id,$input_id){
        // return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
        $form = Form::find($id);
        $categories = Category::all();
        //return view('frontpage.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'categories'=>$categories,'form'=>$form,'showForm'=>true]);
         return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
    }


    public function getGraphData($id)
    {
        $graph = CompanyGraph::where('id', $id)->first();
        $graph_datasource = $graph->companyGraphDataSources()->first();
        $data = [];
        $jsonGraphData = [];
        if($graph_datasource->data_source_type == 'Csv')
        {
            $filePath = public_path('data.csv');
            $file = fopen($filePath, 'r');
            $graphdata = [];
            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                $graphdata[] = $data[0];
            }
            fclose($file);
            $jsonGraphData = $graphdata;
            return $jsonGraphData;
        }
        else if($graph_datasource->data_source_type == 'Api')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'FormInput')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'S3_file')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
    }

    public function showDocument($id,$docpage=null)
    {
        // TODO: Check if user has access to document
        $document = Book::find($id);
        $tabs=[
            ['name'=>'cs_summary','display'=>'Aperçu Generale', 'active'=>true],
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$document->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
        ];
        /*$pages = $document->pages()->get();
        foreach ($pages as $page){
            $tab = ['name'=>'doc_page','display'=>$page->name, 'model_id'=>$page->id];
            array_push($tabs,$tab);
        }
        */
        // TODO: Add access to user_books
        return view('dashboard.document', ['page'=>'doc_page','tabs'=>$tabs, 'document'=>$document]);
    }
    public function showCompany($id)
    {
        // TODO: Check if user has access to document
        $company = Company::find($id);
        $tabs=[
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$company->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
            ['name'=>'cs_documents','display'=>'Documents',]
            ,
        ];

        return view('dashboard.establishments', ['page'=>'doc_page','tabs'=>$tabs, 'company'=>$company]);
    }

    public function showForm($id,$input_id){
        // return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
        $form = Form::find($id);
        $categories = Category::all();
        //return view('frontpage.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'categories'=>$categories,'form'=>$form,'showForm'=>true]);
         return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
    }


    public function getGraphData($id)
    {
        $graph = CompanyGraph::where('id', $id)->first();
        $graph_datasource = $graph->companyGraphDataSources()->first();
        $data = [];
        $jsonGraphData = [];
        if($graph_datasource->data_source_type == 'Csv')
        {
            $filePath = public_path('data.csv');
            $file = fopen($filePath, 'r');
            $graphdata = [];
            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                $graphdata[] = $data[0];
            }
            fclose($file);
            $jsonGraphData = $graphdata;
            return $jsonGraphData;
        }
        else if($graph_datasource->data_source_type == 'Api')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'FormInput')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'S3_file')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
    }

    public function showDocument($id,$docpage=null)
    {
        // TODO: Check if user has access to document
        $document = Book::find($id);
        $tabs=[
            ['name'=>'cs_summary','display'=>'Aperçu Generale', 'active'=>true],
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$document->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
        ];
        /*$pages = $document->pages()->get();
        foreach ($pages as $page){
            $tab = ['name'=>'doc_page','display'=>$page->name, 'model_id'=>$page->id];
            array_push($tabs,$tab);
        }
        */
        // TODO: Add access to user_books
        return view('dashboard.document', ['page'=>'doc_page','tabs'=>$tabs, 'document'=>$document]);
    }
    public function showCompany($id)
    {
        // TODO: Check if user has access to document
        $company = Company::find($id);
        $tabs=[
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$company->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
            ['name'=>'cs_documents','display'=>'Documents',]
            ,
        ];

        return view('dashboard.establishments', ['page'=>'doc_page','tabs'=>$tabs, 'company'=>$company]);
    }

    public function showForm($id,$input_id){
        // return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
        $form = Form::find($id);
        $categories = Category::all();
        //return view('frontpage.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'categories'=>$categories,'form'=>$form,'showForm'=>true]);
         return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
    }


    public function getGraphData($id)
    {
        $graph = CompanyGraph::where('id', $id)->first();
        $graph_datasource = $graph->companyGraphDataSources()->first();
        $data = [];
        $jsonGraphData = [];
        if($graph_datasource->data_source_type == 'Csv')
        {
            $filePath = public_path('data.csv');
            $file = fopen($filePath, 'r');
            $graphdata = [];
            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                $graphdata[] = $data[0];
            }
            fclose($file);
            $jsonGraphData = $graphdata;
            return $jsonGraphData;
        }
        else if($graph_datasource->data_source_type == 'Api')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'FormInput')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'S3_file')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
    }

    public function showDocument($id,$docpage=null)
    {
        // TODO: Check if user has access to document
        $document = Book::find($id);
        $tabs=[
            ['name'=>'cs_summary','display'=>'Aperçu Generale', 'active'=>true],
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$document->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
        ];
        /*$pages = $document->pages()->get();
        foreach ($pages as $page){
            $tab = ['name'=>'doc_page','display'=>$page->name, 'model_id'=>$page->id];
            array_push($tabs,$tab);
        }
        */
        // TODO: Add access to user_books
        return view('dashboard.document', ['page'=>'doc_page','tabs'=>$tabs, 'document'=>$document]);
    }
    public function showCompany($id)
    {
        // TODO: Check if user has access to document
        $company = Company::find($id);
        $tabs=[
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$company->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
            ['name'=>'cs_documents','display'=>'Documents',]
            ,
        ];

        return view('dashboard.establishments', ['page'=>'doc_page','tabs'=>$tabs, 'company'=>$company]);
    }

    public function showForm($id,$input_id){
        // return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
        $form = Form::find($id);
        $categories = Category::all();
        //return view('frontpage.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'categories'=>$categories,'form'=>$form,'showForm'=>true]);
         return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
    }


    public function getGraphData($id)
    {
        $graph = CompanyGraph::where('id', $id)->first();
        $graph_datasource = $graph->companyGraphDataSources()->first();
        $data = [];
        $jsonGraphData = [];
        if($graph_datasource->data_source_type == 'Csv')
        {
            $filePath = public_path('data.csv');
            $file = fopen($filePath, 'r');
            $graphdata = [];
            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                $graphdata[] = $data[0];
            }
            fclose($file);
            $jsonGraphData = $graphdata;
            return $jsonGraphData;
        }
        else if($graph_datasource->data_source_type == 'Api')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'FormInput')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'S3_file')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
    }

    public function showDocument($id,$docpage=null)
    {
        // TODO: Check if user has access to document
        $document = Book::find($id);
        $tabs=[
            ['name'=>'cs_summary','display'=>'Aperçu Generale', 'active'=>true],
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$document->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
        ];
        /*$pages = $document->pages()->get();
        foreach ($pages as $page){
            $tab = ['name'=>'doc_page','display'=>$page->name, 'model_id'=>$page->id];
            array_push($tabs,$tab);
        }
        */
        // TODO: Add access to user_books
        return view('dashboard.document', ['page'=>'doc_page','tabs'=>$tabs, 'document'=>$document]);
    }
    public function showCompany($id)
    {
        // TODO: Check if user has access to document
        $company = Company::find($id);
        $tabs=[
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$company->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
            ['name'=>'cs_documents','display'=>'Documents',]
            ,
        ];

        return view('dashboard.establishments', ['page'=>'doc_page','tabs'=>$tabs, 'company'=>$company]);
    }

    public function showForm($id,$input_id){
        // return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
        $form = Form::find($id);
        $categories = Category::all();
        //return view('frontpage.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'categories'=>$categories,'form'=>$form,'showForm'=>true]);
         return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
    }


    public function getGraphData($id)
    {
        $graph = CompanyGraph::where('id', $id)->first();
        $graph_datasource = $graph->companyGraphDataSources()->first();
        $data = [];
        $jsonGraphData = [];
        if($graph_datasource->data_source_type == 'Csv')
        {
            $filePath = public_path('data.csv');
            $file = fopen($filePath, 'r');
            $graphdata = [];
            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                $graphdata[] = $data[0];
            }
            fclose($file);
            $jsonGraphData = $graphdata;
            return $jsonGraphData;
        }
        else if($graph_datasource->data_source_type == 'Api')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'FormInput')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'S3_file')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
    }

    public function showDocument($id,$docpage=null)
    {
        // TODO: Check if user has access to document
        $document = Book::find($id);
        $tabs=[
            ['name'=>'cs_summary','display'=>'Aperçu Generale', 'active'=>true],
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$document->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
        ];
        /*$pages = $document->pages()->get();
        foreach ($pages as $page){
            $tab = ['name'=>'doc_page','display'=>$page->name, 'model_id'=>$page->id];
            array_push($tabs,$tab);
        }
        */
        // TODO: Add access to user_books
        return view('dashboard.document', ['page'=>'doc_page','tabs'=>$tabs, 'document'=>$document]);
    }
    public function showCompany($id)
    {
        // TODO: Check if user has access to document
        $company = Company::find($id);
        $tabs=[
            ['name'=>'cs_company','display'=>'Entreprise','model_id'=>$company->id],
            ['name'=>'cs_responsables','display'=>'Responsables'],
            ['name'=>'cs_documents','display'=>'Documents',]
            ,
        ];

        return view('dashboard.establishments', ['page'=>'doc_page','tabs'=>$tabs, 'company'=>$company]);
    }

    public function showForm($id,$input_id){
        // return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
        $form = Form::find($id);
        $categories = Category::all();
        //return view('frontpage.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'categories'=>$categories,'form'=>$form,'showForm'=>true]);
         return view('dashboard.form',['page'=>'form_page','form_id'=>$id,'input_id'=>$input_id,'showForm'=>true]);
    }


    public function getGraphData($id)
    {
        $graph = CompanyGraph::where('id', $id)->first();
        $graph_datasource = $graph->companyGraphDataSources()->first();
        $data = [];
        $jsonGraphData = [];
        if($graph_datasource->data_source_type == 'Csv')
        {
            $filePath = public_path('data.csv');
            $file = fopen($filePath, 'r');
            $graphdata = [];
            while (($data = fgetcsv($file, 1000, ',')) !== false) {
                $graphdata[] = $data[0];
            }
            fclose($file);
            $jsonGraphData = $graphdata;
            return $jsonGraphData;
        }
        else if($graph_datasource->data_source_type == 'Api')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'FormInput')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else if($graph_datasource->data_source_type == 'S3_file')
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
        else
        {
            $jsonGraphData = [44, 55, 13, 43, 22];
            return $jsonGraphData;

        }
    }
}
