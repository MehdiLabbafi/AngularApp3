# AngularApp3
# Assignment 6

### Adding Cover Images to Books in BookManager Project

In the latest version of the BookManager project, we have added functionality for uploading and displaying book cover images. Below, I have outlined the key changes made to support this feature.

#### Backend (PHP) Updates
1. **`upload_image.php` Endpoint**: A new PHP file (`upload_image.php`) has been created to handle image uploads. This file processes the incoming image from the Angular frontend and saves it to a designated folder (`uploads/`).
   - The uploaded file is checked for errors before being moved to the `uploads/` directory.
   - The file path is then stored in the database.

2. **Modified `books.php`**: Updates were made to `books.php` to handle the image paths properly:
   - When fetching books from the database, the full URL path of the image is generated to ensure it is displayed correctly in the frontend.
   - During the addition of new books, the uploaded image's file name is stored in the `coverImage` field of the database.

#### Frontend (Angular) Updates
1. **Form Update for Book Addition**:
   - In the `BookListComponent`, a new input type (`file`) has been added to allow users to select a cover image when adding a new book.
   - A new method (`onFileSelected`) handles the file selection and prepares it for uploading.

2. **Image Upload with FormData**:
   - When adding a new book, the selected file is uploaded to the server using `FormData`. The file is then processed by `upload_image.php` on the backend and the resulting file path is saved in the database.

3. **Displaying Cover Images**:
   - In the book list view (`book-list.component.html`), the cover image is displayed using the URL generated from the backend. If no image is provided, a default image is displayed.

#### Database Changes
- The `books` table now includes a `coverImage` column to store the file name of the uploaded image.

#### Example Usage
1. **Adding a Book with a Cover Image**:
   - Go to the 'Add a New Book' section.
   - Fill in the book details and select an image file.
   - Click 'Add Book' to upload the image and save the book.

2. **Viewing Book Covers**:
   - Uploaded book covers are visible in the book list view.
   - If no cover image is uploaded, a default placeholder image is displayed.

These updates allow for a more visually appealing and comprehensive user experience by enabling users to associate images with their books.

 ## Contributors

- **Mehdi Labbafi** - Developer and creator of the project.




# Assignment 5

## Backend API (PHP) for BookManager Project

### Overview
This backend API, developed using PHP, provides functionality for managing the books data in the BookManager project. The backend connects to a MySQL database and allows for various operations like adding, updating, deleting, and fetching books information. It is designed to work seamlessly with the Angular frontend.

### Features
- **GET Request**: Retrieve a list of all books from the database.
- **POST Request**: Add a new book, including details such as title, author, genre, price, rating, and cover image.
- **PUT Request**: Update an existing book's details, identified by its unique ID.
- **DELETE Request**: Remove a book from the database using its ID.
- **CORS Handling**: CORS headers are included to allow communication with the Angular frontend.

### Implementation Details
- **Database Connection**: The backend connects to a MySQL database named `BookManager` using the `PDO` extension for secure and robust database operations.
- **File Structure**: The PHP script handling the API is located in the `BookManagerAPI` folder, and it relies on a separate file (`db.php`) for establishing a connection to the MySQL database.
- **Security and Debugging**:
  - **Error Reporting**: Enabled to assist in debugging (`error_reporting(E_ALL)` and `ini_set('display_errors', 1)`).
  - **Prepared Statements**: Used for database operations to prevent SQL injection attacks.

### API Endpoints
- **GET `/books.php`**: Fetches all the books available in the database.
- **POST `/books.php`**: Adds a new book. The request body should contain `title`, `author`, `genre`, `price`, `rating`, and optionally `coverImage`.
- **PUT `/books.php`**: Updates an existing book. The request body should include `id` along with other details to be updated.
- **DELETE `/books.php?id=ID`**: Deletes the book with the specified `ID`.

### Example Usage
To test the API locally, you can use tools like Postman to send GET, POST, PUT, and DELETE requests to the endpoints listed above. Ensure that the XAMPP server is running, and the API is accessible at `http://localhost/BookManagerAPI/books.php`.

### CORS Configuration
The following headers are set to handle CORS, allowing the Angular frontend to communicate with the backend:
```php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
```
This ensures that requests made from the frontend, even from different origins, are permitted.

### Database Structure
The MySQL table `books` includes the following fields:
- `id` (INT, Primary Key, Auto Increment)
- `title` (VARCHAR)
- `author` (VARCHAR)
- `genre` (VARCHAR)
- `price` (DECIMAL)
- `rating` (FLOAT)
- `coverImage` (VARCHAR, path to the uploaded cover image)

### Common Issues
- **HTTP 500 Errors**: Make sure the database connection (`db.php`) file exists and is correctly configured.
- **CORS Issues**: Ensure the headers are properly set to avoid cross-origin request errors.
- **Cover Images Not Displaying**: Ensure that the `coverImage` field contains the correct path, and the uploaded images are placed in the correct directory.

### Notes
- Ensure XAMPP is running and the database is set up correctly with the name `BookManager`.
- All books data will be stored in the MySQL `books` table, and the API must be accessed through the `http://localhost/BookManagerAPI/` URL.
- The cover images are expected to be uploaded to an `uploads/` directory inside `BookManagerAPI`.

  ## Contributors

- **Mehdi Labbafi** - Developer and creator of the project.


