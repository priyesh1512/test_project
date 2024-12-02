# Hotel Management System  

## Features  

### Controllers and Routing  
#### Controllers:  
- **HotelController**: Manages actions like listing hotels, viewing details, and creating, updating, and deleting hotel records.  
- **BookingController**: Handles bookings, including creating, viewing, updating, and canceling bookings.  

#### Routing:  
- Uses `Route::resource` for RESTful routing.  
- Organized route groups with middleware for access control (e.g., `auth` for authenticated users).  
- Example:  
  ```php
  Route::resource('hotels', HotelController::class);
  Route::resource('bookings', BookingController::class);
  ```  

### CRUD Operations  
- **Create**: Forms for adding new hotels and creating bookings.  
- **Read**: Display available hotels and booking details.  
- **Update**: Admins can edit hotel details, and users can update bookings.  
- **Delete**: Admins can delete hotels, and users can cancel bookings.  
- **Validation**: Use Laravel’s built-in validation for all forms.  

### Authentication and Authorization  
- Authentication: User registration, login, and logout using Laravel’s built-in system.  
- Role-Based Access:  
  - **Admin**: Full access to manage hotels and bookings.  
  - **User**: Limited to creating and managing their bookings.  
- Middleware: Protect routes to enforce proper access control.  

### Blade Templates and Layouts  
- **Master Layout**: `master.blade.php` with a common header, footer, and sidebar.  
- **Dynamic Pages**:  
  - `hotels.blade.php`: Displays a list of available hotels.  
  - `bookings.blade.php`: Shows booking details and forms.  
- **Additional Views**:  
  - Admin Dashboard: Manage hotels and bookings.  
  - User Dashboard: View booking history.  

### Eloquent ORM and Relationships  
- **Models**:  
  - `Hotel`: Represents hotels with details like name, location, and available rooms.  
  - `Booking`: Represents bookings made by users.  
  - `User`: Represents both admin and users with role-based access.  
- **Relationships**:  
  - `Hotel` has many `Bookings`.  
  - `User` has many `Bookings`.  
- **Data Setup**:  
  - Migrations for `hotels`, `bookings`, and `users` tables.  
  - Seeders for populating initial data.  

### Data Validation and Error Handling  
- **Validation**: Enforce rules like `required`, `max`, and `unique` for all forms.  
- **Error Handling**: Display user-friendly error messages on validation failure.  
- **Global Handling**: Use `Handler.php` for consistent error responses.  

### Basic Security Practices  
- **CSRF Protection**: Use `@csrf` in all forms.  
- **Password Hashing**: Use bcrypt for secure password storage.  
- **Input Sanitization**: Prevent XSS attacks using Laravel's sanitization methods.  

### Presentation and Documentation  
- **Documentation**: Include setup instructions and role descriptions.  
- **Project Demo**: Provide screenshots or a video demo showcasing the system.  

### Advanced Features and Enhancements  
- **Search Functionality**: Search and filter options for hotels.  
- **UI/UX Improvements**: Use Bootstrap for responsive design.  
- **Performance Optimization**: Optimize queries and implement caching for frequently accessed data.  
- **Booking Notifications**: Add email notifications for successful bookings.  

## Installation and Setup  
1. Clone the repository.  
2. Install dependencies with `composer install`.  
3. Configure the `.env` file for database and other settings.  
4. Run migrations with `php artisan migrate` and seed the database if necessary.  
5. Start the development server using `php artisan serve`.  

## Roles and Access Levels  
- **Admin**: Manages all aspects of hotels and bookings.  
- **User**: Can create, view, and manage their bookings.  