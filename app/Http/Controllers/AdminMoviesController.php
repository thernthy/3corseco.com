<?php namespace App\Http\Controllers;

	use Session;
	use Request;
	use DB;
	use CRUDBooster;

	class AdminMoviesController extends \crocodicstudio\crudbooster\controllers\CBController {

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "title";
			$this->limit = "50";
			$this->orderby = "created_at,desc";
			$this->global_privilege = false;
			$this->button_table_action = true;
			$this->button_bulk_action = true;
			$this->button_action_style = "button_icon";
			$this->button_add = true;
			$this->button_edit = true;
			$this->button_delete = true;
			$this->button_detail = true;
			$this->button_show = true;
			$this->button_filter = true;
			$this->button_import = false;
			$this->button_export = false;
			$this->table = "titles";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>cbLang('id'),"name"=>"id"];
			$this->col[] = ["label"=>cbLang('title'),"name"=>"title"];
			$this->col[] = ["label"=>cbLang('category_list'),"name"=>"movie_category_id","join"=>"movie_category,name"];
			$this->col[] = ["label"=>cbLang('cover_photo'),"name"=>"movei_cover_path","image"=>true];
			$this->col[] = ["label"=>cbLang('keyword')." ".cbLang('id'),"name"=>"keyword_id","join"=>"keywords,title"];
			$this->col[] = ["label"=>cbLang('director.director')." ".cbLang('id'),"name"=>"actors_id","join"=>"directors,name"];
			$this->col[] = ["label"=>cbLang('status'),"name"=>"status","callback_php"=>'($row->status == 1 ? "<span class=\"label label-success\">Active</span>" : ($row->status == 0 ? "<span class=\"label label-danger\">Inactive</span>" : ($row->status == ""? "<span class=\"label label-danger\">Not set</span>" : "unknown")))'];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ['label'=>'Title','name'=>'title','type'=>'text','validation'=>'required|string','width'=>'col-sm-10','placeholder'=>'You can only enter the letter only'];
			$this->form[] = ['label'=>'Movie Category','name'=>'movie_category_id','type'=>'select','validation'=>'required','width'=>'col-sm-10','datatable'=>'movie_category,name','datatable_format'=>'id,\' - \',name'];
			$this->form[] = ['label'=>'Movei Cover','name'=>'movei_cover_path','type'=>'upload','validation'=>'required|image','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Description','name'=>'description','type'=>'textarea','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Keyword','name'=>'keyword_id','type'=>'select2','width'=>'col-sm-10','datatable'=>'keywords,title','datatable_format'=>'id,\'-\',title'];
			$this->form[] = ['label'=>'Actors Id','name'=>'actors_id','type'=>'select','validation'=>'required','width'=>'col-sm-10','datatable'=>'directors,name'];
			$this->form[] = ['label'=>'Status','name'=>'status','type'=>'radio','validation'=>'required','width'=>'col-sm-10','dataenum'=>'1|public;0|private'];
			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ['label'=>'Title','name'=>'title','type'=>'text','validation'=>'required|string','width'=>'col-sm-10','placeholder'=>'You can only enter the letter only'];
			//$this->form[] = ['label'=>'Movie Category','name'=>'movie_category_id','type'=>'select','validation'=>'required','width'=>'col-sm-10','datatable'=>'movie_category,name','datatable_format'=>'id,\' - \',name'];
			//$this->form[] = ['label'=>'Movei Cover','name'=>'movei_cover_path','type'=>'upload','validation'=>'required|image','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Description','name'=>'description','type'=>'textarea','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Keyword','name'=>'keyword_id','type'=>'select2','width'=>'col-sm-10','datatable'=>'keywords,title','datatable_format'=>'id,\'-\',title'];
			//$this->form[] = ['label'=>'Actors Id','name'=>'actors_id','type'=>'select','validation'=>'required','width'=>'col-sm-10','datatable'=>'directors,name'];
			//$this->form[] = ['label'=>'Status','name'=>'status','type'=>'radio','validation'=>'required','width'=>'col-sm-10','dataenum'=>'1|public;0|private'];
			# OLD END FORM

			/* 
	        | ---------------------------------------------------------------------- 
	        | Sub Module
	        | ----------------------------------------------------------------------     
			| @label          = Label of action 
			| @path           = Path of sub module
			| @foreign_key 	  = foreign key of sub table/module
			| @button_color   = Bootstrap Class (primary,success,warning,danger)
			| @button_icon    = Font Awesome Class  
			| @parent_columns = Sparate with comma, e.g : name,created_at
	        | 
	        */
	        $this->sub_module = array();


	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add More Action Button / Menu
	        | ----------------------------------------------------------------------     
	        | @label       = Label of action 
	        | @url         = Target URL, you can use field alias. e.g : [id], [name], [title], etc
	        | @icon        = Font awesome class icon. e.g : fa fa-bars
	        | @color 	   = Default is primary. (primary, warning, succecss, info)     
	        | @showIf 	   = If condition when action show. Use field alias. e.g : [id] == 1
	        | 
	        */
	        $this->addaction = array();


	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add More Button Selected
	        | ----------------------------------------------------------------------     
	        | @label       = Label of action 
	        | @icon 	   = Icon from fontawesome
	        | @name 	   = Name of button 
	        | Then about the action, you should code at actionButtonSelected method 
	        | 
	        */
	        $this->button_selected = array();

	                
	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add alert message to this module at overheader
	        | ----------------------------------------------------------------------     
	        | @message = Text of message 
	        | @type    = warning,success,danger,info        
	        | 
	        */
	        $this->alert        = array();
	                

	        
	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add more button to header button 
	        | ----------------------------------------------------------------------     
	        | @label = Name of button 
	        | @url   = URL Target
	        | @icon  = Icon from Awesome.
	        | 
	        */
	        $this->index_button = array();



	        /* 
	        | ---------------------------------------------------------------------- 
	        | Customize Table Row Color
	        | ----------------------------------------------------------------------     
	        | @condition = If condition. You may use field alias. E.g : [id] == 1
	        | @color = Default is none. You can use bootstrap success,info,warning,danger,primary.        
	        | 
	        */
	        $this->table_row_color = array();     	          

	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | You may use this bellow array to add statistic at dashboard 
	        | ---------------------------------------------------------------------- 
	        | @label, @count, @icon, @color 
	        |
	        */
	        $this->index_statistic = array();



	        /*
	        | ---------------------------------------------------------------------- 
	        | Add javascript at body 
	        | ---------------------------------------------------------------------- 
	        | javascript code in the variable 
	        | $this->script_js = "function() { ... }";
	        |
	        */
	        $this->script_js = null;
	        $this->script_js .= "
				// input
				$('.select2').select2();";

            /*
	        | ---------------------------------------------------------------------- 
	        | Include HTML Code before index table 
	        | ---------------------------------------------------------------------- 
	        | html code to display it before index table
	        | $this->pre_index_html = "<p>test</p>";
	        |
	        */
	        $this->pre_index_html = null;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include HTML Code after index table 
	        | ---------------------------------------------------------------------- 
	        | html code to display it after index table
	        | $this->post_index_html = "<p>test</p>";
	        |
	        */
	        $this->post_index_html = null;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include Javascript File 
	        | ---------------------------------------------------------------------- 
	        | URL of your javascript each array 
	        | $this->load_js[] = asset("myfile.js");
	        |
	        */
	        $this->load_js = array();
	        $this->load_js[] = asset("vendor/crudbooster/assets/select2/dist/js/select2.full.min.js");
			$this->load_js[] = asset("vendor/crudbooster/assets/summernote/summernote.min.js");
	        /*
	        | ---------------------------------------------------------------------- 
	        | Add css style at body 
	        | ---------------------------------------------------------------------- 
	        | css code in the variable 
	        | $this->style_css = ".style{....}";
	        |
	        */
	        $this->style_css = NULL;
	        $this->style_css = "

				.select2-container--default .select2-selection--single {
					border-radius: 0px !important
				}
				.select2-container .select2-selection--single {
					height: 35px !important
				}
				.select2-container--default .select2-selection--multiple .select2-selection__choice {
					background-color: #3c8dbc !important;
					border-color: #367fa9 !important;
					color: #fff !important;
				}
				.select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
					color: #fff !important;
				}
				.select2-container {
					width:100%;
				}
			";
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include css File 
	        | ---------------------------------------------------------------------- 
	        | URL of your css each array 
	        | $this->load_css[] = asset("myfile.css");
	        |
	        */
	        $this->load_css = array();
	        $this->load_css[] = asset("vendor/crudbooster/assets/select2/dist/css/select2.min.css");
			$this->load_css[] = asset("vendor/crudbooster/assets/summernote/summernote.css");
	    }


	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for button selected
	    | ---------------------------------------------------------------------- 
	    | @id_selected = the id selected
	    | @button_name = the name of button
	    |
	    */
	    public function actionButtonSelected($id_selected,$button_name) {
	        //Your code here
	            
	    }


	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate query of index result 
	    | ---------------------------------------------------------------------- 
	    | @query = current sql query 
	    |
	    */
	    public function hook_query_index(&$query) {
	        //Your code here
	            
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate row of index table html 
	    | ---------------------------------------------------------------------- 
	    |
	    */    
	    public function hook_row_index($column_index,&$column_value) {	        
	    	//Your code here
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before add data is execute
	    | ---------------------------------------------------------------------- 
	    | @arr
	    |
	    */
	    public function hook_before_add(&$postdata) {        
	        //Your code here
	        $postdata['keyword_id'] = serialize($postdata['keyword_id']);
	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after add public static function called 
	    | ---------------------------------------------------------------------- 
	    | @id = last insert id
	    | 
	    */
	    public function hook_after_add($id) {        
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before update data is execute
	    | ---------------------------------------------------------------------- 
	    | @postdata = input post data 
	    | @id       = current id 
	    | 
	    */
        public function hook_before_edit(&$postdata, $id) {
                $postdata['keyword_id'] = serialize($postdata['keyword_id']);
                // Fetch the default value from the database
                $defaultValue = DB::table('titles')->where('id', $id)->value('movei_cover_path');
                // Check if the movei_cover_path field is empty in the form data
                if (empty($postdata['movei_cover_path'])) {
                    // Set the default value from the database
                    $postdata['movei_cover_path'] = $defaultValue;
                }
        }


	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after edit public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_after_edit($id) {
	        //Your code here 
            
	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command before delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_before_delete($id) {
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_after_delete($id) {
	        DB::table('videos')->where('title_id', $id)->delete();
	    }


	    //By the way, you can still create your own method in here... :) 
	    public function getAdd(){
			$data['page_title'] = "Add movie";
			$data['category'] = DB::table('movie_category')
				->select('name as val', 'id')
				->get();
			$data['keyword'] = DB::table('keywords')
				->select('title as val', 'id')
				->get();
			$data['actors_id'] = DB::table('directors')
				->select('name as val', 'id')
				->get();
			return $this->view('custom_adminn_view.movie.add', $data);
		}
		
		//get edit function 
		public function getEdit($id){
			//Create an Auth
			if(!CRUDBooster::isUpdate() && $this->global_privilege==FALSE || $this->button_edit==FALSE) {    
				CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
			}

			$data = [];
			$data['page_title'] = 'Edit Activity';
			$data['row'] = DB::table('titles')
				->where(
					'id',
					$id
					)
				->first();
			//dd($data['row']);
			$data['page_title'] = "Edit movie";
			$data['category'] = DB::table('movie_category')
				->select('name as val', 'id')
				->get();
			$data['keyword'] = DB::table('keywords')
				->select('title as val', 'id')
				->get();
			$data['actors_id'] = DB::table('directors')
				->select('name as val', 'id')
				->get();
			return $this->view('custom_adminn_view.movie.edit', $data);
		}


	}