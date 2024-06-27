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

Sure, here's a more concise summary:

- `POST /api/v1/auth/register`: Registers a new user with `name`, `email`, and `password`. Returns an access token.
- `POST /api/v1/auth/login`: Authenticates a user with `email` and `password`. Returns an access token or a validation
  error.
- `POST /api/v1/auth/logout`: Logs out the authenticated user and deletes the current access token.
- `PUT /api/v1/auth/password`: Updates the authenticated user's password. Returns a success message or an error if the
  new password is the same as the current one.
- `PUT /api/v1/auth/profile`: Updates the authenticated user's profile information. Returns the updated data.
- `GET /api/v1/auth/profile`: Returns the authenticated user's 'name' and 'email'.
-
- `GET /api/v1/vehicles`: Displays a list of all vehicles. This method returns a collection of all vehicles in the
  database, each transformed into a 'VehicleResource'.

- `POST /api/v1/vehicles`: Stores a new vehicle in the database. This method first validates the request data using
  the 'StoreVehicleRequest' class. If the data is valid, it creates a new vehicle in the database and returns a new
  instance of 'VehicleResource' representing the newly created vehicle. Expects a request body with the vehicle data to
  be created.

- `GET /api/v1/vehicles/{vehicle}`: Displays the information of a specific vehicle. This method returns a new instance
  of 'VehicleResource', passing the specific vehicle.

- `PUT /api/v1/vehicles/{vehicle}`: Updates the information of a specific vehicle. This method first validates the
  request data using the 'StoreVehicleRequest' class. If the data is valid, it updates the vehicle in the database and
  returns a JSON response with a new instance of 'VehicleResource', passing the updated vehicle, and an HTTP status code
  202 (Accepted). Expects a request body with the new vehicle data.

- `DELETE /api/v1/vehicles/{vehicle}`: Deletes a specific vehicle. This method deletes the vehicle from the database and
  returns an HTTP response with status 204 (No Content), indicating that the operation was successful and there is no
  content to return.
-
- `GET /api/v1/zones`: Lists all zones. This method authorizes the 'viewAny' action for the Zone class, meaning that any
  user, authenticated or not, is allowed to view the list of zones. It retrieves all zones from the database using the '
  all' method on the 'Zone' class. Then, it returns these zones as a collection of 'ZoneResource' resources, which
  transform each 'Zone' instance into an array formatted for the API response.

## Contributing

Contributions are welcome! Please read the contribution guidelines before submitting a pull request.

## License

This project is licensed under the MIT license. See the `LICENSE` file for more details.

## Autor

Isaias Xavier

- Profile: [https://github.com/isaiasxavier](https://github.com/isaiasxavier)
- Project: [https://github.com/isaiasxavier/parking_app](https://github.com/isaiasxavier/parking_app)
