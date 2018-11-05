<?php

    class user{
        protected $user_ID;
        protected $user_type;
        protected $email;
        protected $displayed_name;
        protected $full_name;
        protected $password;
        protected $date_created;
        
        function get_user_ID(){
            return $this->user_ID;
        }
        
        function get_user_type(){
            return $this->user_type;
        }
        
        function get_email(){
            return $this->email;
        }
        
        function get_displayed_name(){
            return $this->displayed_name;
        }
        function get_date_created(){
            return $this->date_created;
        }

    }