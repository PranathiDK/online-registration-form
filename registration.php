<?php
// --- PART 1: PHP Server-Side Logic ---

// This variable will track if the form was submitted
$is_submitted = false;
$form_data = [];

// Check if the request method is POST, which means the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $is_submitted = true;
    
    // Sanitize and store each form field to prevent XSS attacks
    // We use htmlspecialchars() to make the data safe to display
    $form_data = [
        'first_name' => isset($_POST['first_name']) ? htmlspecialchars($_POST['first_name']) : '',
        'last_name'  => isset($_POST['last_name']) ? htmlspecialchars($_POST['last_name']) : '',
        'email'      => isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '',
        'phone'      => isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '',
        'course'     => isset($_POST['course']) ? htmlspecialchars($_POST['course']) : '',
        'comments'   => isset($_POST['comments']) ? htmlspecialchars($_POST['comments']) : ''
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Application Form</title>
    
    <!-- Load Tailwind CSS for styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Load jQuery for client-side validation -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- Custom styles for error messages -->
    <style>
        /* Simple style for our error spans */
        .error-message {
            color: #ef4444; /* red-500 */
            font-size: 0.875rem; /* text-sm */
        }
    </style>
</head>
<body class="bg-gradient-to-r from-indigo-50 via-purple-50 to-pink-50 font-sans antialiased">

    <div class="container mx-auto max-w-2xl p-8 my-10 bg-white rounded-lg shadow-2xl overflow-hidden">

        <?php if ($is_submitted): ?>
            
            <!-- --- PART 2: Display Submitted Data --- -->
            <!-- This block is shown ONLY if the form was successfully submitted -->
            
            <h1 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-green-500 to-teal-600 mb-6">Registration Successful!</h1>
            <p class="text-lg text-gray-700 mb-6">Thank you for your application. Here is the information you submitted:</p>
            
            <div class="space-y-4">
                <div class="p-4 bg-green-50 border-l-4 border-green-500 rounded-r-lg">
                    <strong class="text-gray-900 block">First Name:</strong>
                    <span class="text-gray-700"><?php echo $form_data['first_name']; ?></span>
                </div>
                <div class="p-4 bg-green-50 border-l-4 border-green-500 rounded-r-lg">
                    <strong class="text-gray-900 block">Last Name:</strong>
                    <span class="text-gray-700"><?php echo $form_data['last_name']; ?></span>
                </div>
                <div class="p-4 bg-green-50 border-l-4 border-green-500 rounded-r-lg">
                    <strong class="text-gray-900 block">Email Address:</strong>
                    <span class="text-gray-700"><?php echo $form_data['email']; ?></span>
                </div>
                <div class="p-4 bg-green-50 border-l-4 border-green-500 rounded-r-lg">
                    <strong class="text-gray-900 block">Phone Number:</strong>
                    <span class="text-gray-700"><?php echo $form_data['phone']; ?></span>
                </div>
                <div class="p-4 bg-green-50 border-l-4 border-green-500 rounded-r-lg">
                    <strong class="text-gray-900 block">Selected Course:</strong>
                    <span class="text-gray-700"><?php echo $form_data['course']; ?></span>
                </div>
                <div class="p-4 bg-green-50 border-l-4 border-green-500 rounded-r-lg">
                    <strong class="text-gray-900 block">Comments:</strong>
                    <span class="text-gray-700"><?php echo nl2br($form_data['comments']); // nl2br preserves line breaks ?></span>
                </div>
            </div>
            
            <a href="registration.php" class="inline-block mt-8 w-full text-center px-6 py-3 bg-gradient-to-r from-purple-500 to-indigo-600 text-white font-medium rounded-lg shadow-md hover:from-purple-600 hover:to-indigo-700 transition duration-300">
                Submit Another Application
            </a>

        <?php else: ?>

            <!-- --- PART 3: Display Registration Form --- -->
            <!-- This block is shown by default, when the page first loads -->
            
            <h1 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-indigo-700 mb-6">Online Application Form</h1>
            <p class="text-gray-600 mb-8">Please fill out the form below to register.</p>

            <!-- 
              The form "action" is empty, which means it will submit to this same file (registration.php)
              The "method" is "POST", which our PHP logic at the top is looking for.
              "novalidate" disables the browser's default validation, so we can use our jQuery validation.
            -->
            <form id="applicationForm" action="registration.php" method="POST" novalidate>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- First Name -->
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                        <input type="text" name="first_name" id="first_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <span id="firstNameError" class="error-message"></span>
                    </div>
                    
                    <!-- Last Name -->
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                        <input type="text" name="last_name" id="last_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <span id="lastNameError" class="error-message"></span>
                    </div>
                    
                    <!-- Email Address -->
                    <div class="md:col-span-2">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                        <input type="email" name="email" id="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <span id="emailError" class="error-message"></span>
                    </div>
                    
                    <!-- Phone Number -->
                    <div class="md:col-span-2">
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                        <input type="tel" name="phone" id="phone" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="e.g., (123) 456-7890">
                        <span id="phoneError" class="error-message"></span>
                    </div>

                    <!-- Course Selection -->
                    <div class="md:col-span-2">
                        <label for="course" class="block text-sm font-medium text-gray-700 mb-2">Select Course</label>
                        <select name="course" id="course" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">Please select a course...</option>
                            <option value="Web Development">Web Development</option>
                            <option value="Data Science">Data Science</option>
                            <option value="Digital Marketing">Digital Marketing</option>
                            <option value="UX/UI Design">UX/UI Design</option>
                        </select>
                        <span id="courseError" class="error-message"></span>
                    </div>
                    
                    <!-- Comments -->
                    <div class="md:col-span-2">
                        <label for="comments" class="block text-sm font-medium text-gray-700 mb-2">Comments (Optional)</label>
                        <textarea name="comments" id="comments" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="md:col-span-2 flex items-center">
                        <input type="checkbox" name="terms" id="terms" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                        <label for="terms" class="ml-2 block text-sm text-gray-900">I agree to the <a href="#" class="text-indigo-600 hover:text-indigo-800 hover:underline">Terms and Conditions</a></label>
                    </div>
                    <span id="termsError" class="error-message md:col-span-2 -mt-5"></span>

                </div>
                
                <!-- Submit Button -->
                <div class="mt-8">
                    <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-purple-500 to-indigo-600 text-white font-medium rounded-lg shadow-md hover:from-purple-600 hover:to-indigo-700 transition duration-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Submit Application
                    </button>
                </div>
            </form>

        <?php endif; ?>

    </div>
    
    
    <!-- --- PART 4: jQuery Client-Side Validation --- -->
    <script>
        $(document).ready(function() {
            // Intercept the form's submit event
            $('#applicationForm').on('submit', function(event) {
                let isValid = true;
                
                // Clear all previous error messages
                $('.error-message').text('');
                
                // --- Validation Rules ---
                
                // First Name: Must not be empty
                if ($('#first_name').val().trim() === '') {
                    $('#firstNameError').text('First name is required.');
                    isValid = false;
                }
                
                // Last Name: Must not be empty
                if ($('#last_name').val().trim() === '') {
                    $('#lastNameError').text('Last name is required.');
                    isValid = false;
                }
                
                // Email: Must not be empty and be a valid format
                let email = $('#email').val().trim();
                let emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
                if (email === '') {
                    $('#emailError').text('Email is required.');
                    isValid = false;
                } else if (!emailRegex.test(email)) {
                    $('#emailError').text('Please enter a valid email address.');
                    isValid = false;
                }
                
                // Course: Must select one
                if ($('#course').val() === '') {
                    $('#courseError').text('Please select a course.');
                    isValid = false;
                }

                // Terms: Must be checked
                if (!$('#terms').is(':checked')) {
                    $('#termsError').text('You must agree to the terms and conditions.');
                    isValid = false;
                }

                // --- End of Validation ---
                
                // If any validation rule failed, prevent the form from submitting
                if (!isValid) {
                    event.preventDefault();
                }
                // If 'isValid' is still true, the form will submit as normal to the PHP script
            });
        });
    </script>

</body>
</html>