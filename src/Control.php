<?php
//This class is used to preprocess the request
    class Control {
        public function __construct(private Gateway $gateway) {
        }
        public function request_proccess(string $request_method, ?string $id): void {
            
            if($id){
                $this->resource_request($request_method, $id);
            } else {
                $this->collection_request($request_method);
            }
        }
        private function collection_request(string $request_method): void {
            switch($request_method){
                case "GET":
                    echo json_encode($this->gateway->get_all());
                    break;
                case "POST":
                    $data = (array)json_decode(file_get_contents("php://input"),true);
                    // the first argument is the file path and the second argument is the type of data you want to return and true is used to return the data in an array
                    // file_get_contents is a PHP function that reads a file into a string and php://input is a read-only stream that allows you to read raw data from the request body.
                    // $_POST is a PHP super global variable which is used to collect form data after submitting an HTML form with method="post".
                    $this->gateway->create($data);
                    echo json_encode(["id" => $this->gateway->create($data)]);
                    break;
            }
        }
        private function resource_request(string $request_method, string $id): void {
            switch($request_method){
                case "GET":
                    echo json_encode($this->gateway->getById($id));
                    break;
            }   
        }
        private function validate_data(array $data): array {
            $error = [];
            if(!isset($data["username"])){
                $error[] = "Username is required";
            }
            if(!isset($data["first_name"])){
                $error[] = "First name is required";
            }
            if(!isset($data["last_name"])){
                $error[] = "Last name is required";
            }
            if(!isset($data["email"])){
                $error[] = "Email is required";
            }
            if(!isset($data["Gender"])){
                $error[] = "Gender is required";
            } else if($data["Gender"]!="M" && $data["Gender"]!="F"){
                $error[] = "Gender must be M or F";
            }
            if(!isset($data["is_active"])){
                $error[] = "is_active is required";
            } else if($data["is_active"]!="true" && $data["is_active"]!="false"){
                $error[] = "is_active must be true or false";
            }
    }
}