<?php

    namespace Marve\Ela\Controllers;
    use Marve\Ela\Core\Controller;


    class ModelController extends Controller
    {
                
        protected $key;

         public function __construct(string $key) 
        {
            $this->key = $key;
        }            
        protected function store($data)
        {               
            if(isset($data->{$this->key}) && $this->class->exists($this->key, $data->{$this->key}))
            {
                $this->request = $this->class->edit($data,$data->{$this->key}, $this->key);			
            }
            else
            {	                           	                   
                $this->request = $this->class->store($data);			
            }	    
            return $this->request; 
        }
            
        protected function get($data)
        {	    	    
            $this->request =$this->class->get($data->{$this->key}, $this->key);	    
            return $this->request;
        }

    }   