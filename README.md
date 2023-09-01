# Quiz System in Laravel

## Project Description
The Quiz System is a simple multiple-choice quiz application designed for teachers to quiz their students and evaluate their performance. This system includes several features to make the quizzing process efficient and convenient.

### Features

1. **Quiz Time Limit**
    - The quiz has a predefined time limit of 20 minutes. Once this time elapses, the student's session for the exam will be expired automatically.

2. **Single Attempt**
    - Each student can attempt the quiz only once to maintain fairness and prevent cheating.

3. **Email Notification**
    - After a student completes the quiz, an email notification will be sent to the admin.

4. **Admin Review and Communication**
    - The admin receives an email notification when a student finishes a quiz. The admin can then resend an email to the student with their score and result (Accepted or Rejected).

5. **Private Access**
    - The quiz system is private, and all users, including admins, must log in to access it.

6. **User Functionality**
    - Regular users (students) can:
        - Log in
        - Take a test
        - Answer multiple-choice questions
        - Review a report of their answers, including correct answers and their grade.

7. **Admin Functionality**
    - Admins can:
        - Create quizzes with multiple-choice questions
        - Receive email notifications when students finish quizzes
        - Resend email notifications to students with their scores and results.

### Quiz Questions
- The quiz questions are multiple-choice only, with each question having four choices and one correct answer.

## Usage
To set up and use the Quiz System, follow these steps:

1. **Installation**
    - Clone this repository to your local machine.

2. **Database Setup**
    - Configure your database settings in the `.env` file.

3. **Migrate and Seed Database**
    - Run the following commands to set up the database and seed it with initial data:
      ```bash
      php artisan migrate
      php artisan db:seed
      ```

4. **Admin Creation**
    - To create an admin, use the following command:
      ```bash
      php artisan create:admin
      ```

5. **Run the Application**
    - Start the development server:
      ```bash
      php artisan serve
      ```
    - Start the Queue Worker:
      ```bash
      php artisan queue:work
      ```

6. **Access the Application**
    - Open your web browser and navigate to `http://localhost:8000` to access the Quiz System.

## Contributing
Contributions are welcome! If you have suggestions or would like to report issues, please create a GitHub issue or submit a pull request.

## License
This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Contact
For any questions or inquiries, please contact [Your Name] at [Your Email Address].
