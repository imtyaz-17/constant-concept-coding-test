<!DOCTYPE html>
<html>
<head>
    <title>Language Switcher</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .header-image {
            max-width: 600px;
            width: 100%;
            max-height: 200px;
            object-fit: contain;
            margin-bottom: 20px;
        }
        .language-switcher {
            margin-bottom: 20px;
        }
        .form-container {
            margin-top: 20px;
        }
        .result {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ccc;
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
            'title' => 'Simple Form',
            'input_label' => 'Enter your name',
            'submit_button' => 'Submit',
            'switch_to' => 'Switch to Polish',
            'response_prefix' => 'Your input: '
        ],
        'pl' => [
            'title' => 'Prosty Formularz',
            'input_label' => 'Wpisz swoje imię',
            'submit_button' => 'Wyślij',
            'switch_to' => 'Przełącz na angielski',
            'response_prefix' => 'Twoje dane: '
        ]
    ];
    
    $t = $translations[$lang];
    ?>

    <img src="./constant_concept_inc_logo.jpeg" alt="Header Image" class="header-image">
    
    <div class="language-switcher">
        <button id="langToggle" data-current-lang="<?php echo $lang; ?>">
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
            <div style="margin-top: 10px;">
                <button type="submit"><?php echo $t['submit_button']; ?></button>
            </div>
        </form>
    </div>
    
    <div id="result" class="result"></div>
    
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
                success: function(response) {
                    try {
                        const data = JSON.parse(response);
                        $('#result').html(t.response_prefix + data.userInput);
                        $('#result').show();
                    } catch (e) {
                        $('#result').html(t.response_prefix + response);
                        $('#result').show();
                    }
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