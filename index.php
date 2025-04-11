<!DOCTYPE html>
<html>
<head>
    <title>Language Switcher</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
        }
        .container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 25px;
        }
        .header-image {
            max-width: 600px;
            width: 100%;
            max-height: 200px;
            object-fit: contain;
            margin: 0 auto 25px;
            display: block;
        }
        .language-switcher {
            margin-bottom: 20px;
            text-align: right;
        }
        .language-button {
            background-color: #4a6fa5;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 14px;
        }
        .language-button:hover {
            background-color: #3a5c8d;
        }
        h1 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 25px;
            font-weight: 500;
        }
        .form-container {
            margin-top: 30px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #555;
        }
        input[type="text"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
            margin-bottom: 20px;
            transition: border-color 0.3s;
        }
        input[type="text"]:focus {
            border-color: #4a6fa5;
            outline: none;
            box-shadow: 0 0 0 2px rgba(74, 111, 165, 0.2);
        }
        button[type="submit"] {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        button[type="submit"]:hover {
            background-color: #218838;
        }
        .result {
            margin-top: 25px;
            padding: 15px;
            border-radius: 4px;
            border-left: 4px solid #4a6fa5;
            background-color: #f0f4f8;
            display: none;
        }
    </style>
</head>
<body>
    <?php
    // Language detection
    $lang = isset($_GET['lang']) && ($_GET['lang'] === 'pl') ? 'pl' : 'en';
    
    // Language translations
    $translations = [
        'en' => [
            'title' => 'Name Form',
            'input_label' => 'Enter your name',
            'submit_button' => 'Submit',
            'switch_to' => 'Switch to Polish',
            'response_prefix' => 'Your input: '
        ],
        'pl' => [
            'title' => 'Formularz nazwy',
            'input_label' => 'Wpisz swoje imię',
            'submit_button' => 'Wyślij',
            'switch_to' => 'Przełącz na angielski',
            'response_prefix' => 'Twoje dane: '
        ]
    ];
    
    $t = $translations[$lang];
    ?>

    <div class="container">
        <img src="./constant_concept_inc_logo.jpeg" alt="Header Image" class="header-image">
        
        <div class="language-switcher">
            <button id="langToggle" class="language-button" data-current-lang="<?php echo $lang; ?>">
                <?php echo $t['switch_to']; ?>
            </button>
        </div>
        
        <h1><?php echo $t['title']; ?></h1>
        
        <div class="form-container">
            <form id="ajaxForm">
                <div>
                    <label for="userInput"><?php echo $t['input_label']; ?>:</label>
                    <input type="text" id="userInput" name="userInput" required>
                </div>
                <div style="text-align: center; margin-top: 10px;">
                    <button type="submit"><?php echo $t['submit_button']; ?></button>
                </div>
            </form>
        </div>
        
        <div id="result" class="result"></div>
    </div>
    
    <script>
    $(document).ready(function() {
        // Store translations in JavaScript
        const translations = <?php echo json_encode($translations); ?>;
        let currentLang = '<?php echo $lang; ?>';
        
        // Language toggle
        $('#langToggle').click(function() {
            currentLang = currentLang === 'en' ? 'pl' : 'en';
            // Update URL without reloading
            const url = new URL(window.location);
            url.searchParams.set('lang', currentLang);
            window.history.pushState({}, '', url);
            
            // Update content
            updateContent(currentLang);
        });
        
        function updateContent(lang) {
            const t = translations[lang];
            
            // Update text elements
            $('h1').text(t.title);
            $('label[for="userInput"]').text(t.input_label + ':');
            $('#ajaxForm button[type="submit"]').text(t.submit_button);
            $('#langToggle').text(t.switch_to);
            $('#langToggle').data('current-lang', lang);
            
            // Update current language
            currentLang = lang;
        }
        
        // Form submission
        $('#ajaxForm').submit(function(e) {
            e.preventDefault();
            
            const userInput = $('#userInput').val();
            const t = translations[currentLang];
            
            $.ajax({
                url: 'process.php',
                type: 'POST',
                data: { 
                    userInput: userInput,
                    lang: currentLang
                },
                dataType: 'json',
                success: function(response) {
                    $('#result').html(t.response_prefix + response.userInput);
                    $('#result').show();
                },
                error: function() {
                    alert('An error occurred');
                }
            });
        });
    });
    </script>
</body>
</html> 