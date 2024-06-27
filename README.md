# Car Parking Application API

This project is an API developed to manage a car parking system.

## Technologies Used

- PHP
- NPM
- Composer
- Laravel

## Project Setup

To set up the project, follow the steps below:

1. Clone the repository with `git clone https://github.com/isaiasxavier/parking_app.git`
2. Navigate to the project directory with `cd parking_app`
3. Install the dependencies with `composer install` and `npm install`

## API Routes

The API has the following routes:

- `POST /api/v1/auth/register`: Registers a new user in the system. This method first validates the request data using
  the 'UserRequest' class. Then, it creates a new user with the validated data. The user's password is hashed using
  the 'Hash::make' function. Then, it fires a 'Registered' event for the new user. The device name is extracted from the
  user agent being used as the token name. Finally, it returns a JSON response that includes the access token. Expects a
  request body with the fields `name`, `email`, and `password`.
- `POST /api/v1/auth/login`: Authenticates a user and generates an access token. Expects a request body with the
  fields  `email` and `password`. If the user is found and the password matches, it returns a JSON response containing
  the access token. If the user is not found or the password does not match, it returns a validation error. Optionally,
  a `remember` field can be included in the request body to control the expiration of the token.
- `POST /api/v1/auth/logout`: Logs out the authenticated user. This method retrieves the authenticated user through
  the 'auth()' helper, and then deletes the current access token. After deleting the token, it returns an HTTP response
  with status 204 (No Content), indicating that the operation was successful and there is no content to return.
- `PUT /api/v1/auth/password`: Updates the password of the authenticated user. This method receives
  a `PasswordUpdateRequest` object that validates the input data. It first checks if the new password is the same as the
  current password. If it is, it returns a JSON response with an error message and an HTTP status code 422 (
  Unprocessable Entity). If the new password is different from the current password, it updates the user's password in
  the database and returns a JSON response with a success message and an HTTP status code 202 (Accepted). Expects a
  request body with the field `password`.
- `PUT /api/v1/auth/profile`: Updates the authenticated user's profile information. This method validates the received
  data through the 'ProfileRequest' object, updates the authenticated user's information, and returns a JSON with the
  validated data and an HTTP status code 202 (Accepted). Expects a request body with the fields that need to be updated.
- `GET /api/v1/auth/profile`: Displays the authenticated user's profile information. This method returns a JSON with
  the 'name' and 'email' fields of the authenticated user.

## Contributing

Contributions are welcome! Please read the contribution guidelines before submitting a pull request.

## License

This project is licensed under the MIT license. See the `LICENSE` file for more details.

## Autor

Isaias Xavier

- Profile: [https://github.com/isaiasxavier](https://github.com/isaiasxavier)
- Project: [https://github.com/isaiasxavier/parking_app](https://github.com/isaiasxavier/parking_app)
