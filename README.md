## Exam API

This is a Web API service for an exam platform. This APIs can be consumed by any modern JavaScript framework. React was utilized for this project

## Features
- Authentication.
- Assessment module for creating an assessment. Specifying the duration, expected score, title and so on
- Questions. Each assessment has a list of questions. And each question can be multiple or single choice.
- Options. Each question has a list of options. An option can have multiple correct answers or a single correct answer depending on the type of question.
- Grading. A user will be graded after completing an assessment
- Authorization. Gates and Policies were implemented to allow only admin users to create assessment with their associated questions and options. Normal users (tagged as students) can only view those resources
- User. An admin can create other users (students or admins).


## How to run this project
It is assumed you know how to run a Laravel project on your local machine

1. Make sure you have PHP 8.1 or newer
2. Clone this repository
3. Navigate to the root directory of the cloned project on your local machine and run the following commands

> `cp .env.example .env` then update the .env file with your database credentials

> `composer install` to install dependencies

> `php artisan key:generate`

> `php artisan migrate`

> `php artisan db:seed` to seed default admin user data

> `php artisan serve` to run your API server on http://127.0.0.1:8080

The API documentation can be found here on [Postman](https://www.postman.com/winter-zodiac-860699/workspace/exam-api/collection/8952704-388c4eaf-7f06-4d44-9bac-5e30e764cf50?action=share&creator=8952704&active-environment=8952704-48e1762c-fbc6-4844-8c76-3e7b462aca12)

If you ran `php artisan db:seed`, proceed to test the endpoints on postman
