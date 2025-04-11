<?php
/**
 * Class to handle form responses
 */
class ResponseHandler {
    private $data;
    private $lang;
    
    /**
     * Constructor
     * 
     * @param array $data The input data from the form
     * @param string $lang The current language
     */
    public function __construct($data, $lang) {
        $this->data = $data;
        $this->lang = $lang;
    }
    
    /**
     * Get and format the response
     * 
     * @return array The formatted response
     */
    public function getResponse() {
        return [
            'userInput' => htmlspecialchars($this->data['userInput']),
            'lang' => $this->lang
        ];
    }
}

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get input data
    $userInput = isset($_POST['userInput']) ? $_POST['userInput'] : '';
    $lang = isset($_POST['lang']) ? $_POST['lang'] : 'en';
    
    // Create response handler
    $handler = new ResponseHandler(['userInput' => $userInput], $lang);
    
    // Get and output response
    header('Content-Type: application/json');
    echo json_encode($handler->getResponse());
} else {
    // Handle invalid request
    header('HTTP/1.1 400 Bad Request');
    echo 'Invalid request method';
} 