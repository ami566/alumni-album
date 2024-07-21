# Alumni Album

## 1. Overview
The project aims to develop a web-based system for managing alumni data, organizing photo sessions, and creating personalized photo products. The system is designed to handle various functionalities, including data registration, import/export, photo session management, and the creation of photo products based on user requests.

## 2. Requirements
### Roles
- **Administrator**: Manages alumni data and system configuration.
- **User (Alumni)**: Registers, uploads personal photos, and requests photo sessions.
- **Photographer**: Uploads session photos and provides selection options.

### Functional Requirements
1. **Alumni Data Management**:
   - Register new alumni.
   - Import/export alumni data by group, stream, major, and graduation year.
   - Edit alumni data.

2. **Photo Session Management**:
   - Upload personal photos.
   - Upload session photos with selection options.
   - Request group photos.

3. **Photo Product Export/Printing**:
   - Export photo albums.
   - Print cards, calendars, mugs, and bridge cards.

### Non-Functional Requirements
- User-friendly interface.
- Data security.
- Scalability.
- Reliability.

## 3. System Design
### Modules and Components
1. **Alumni Data Management Module**:
   - Registration Component
   - Import/Export Component
   - Data Editing Component

2. **Photo Session Management Module**:
   - Photo Upload Component
   - Photographer Component
   - Group Photo Request Component

3. **Photo Product Creation Module**:
   - Photo Album Export Component
   - Personalized Products Component

### Application Parts
1. **User Interface (UI)**:
   - Registration Form
   - Import/Export Screen
   - Data Editing Screen
   - Photo Upload Screen
   - Photo Selection Interface
   - Group Photo Request Screen
   - Photo Product Creation Interface

2. **Server Backend**:
   - Alumni Database
   - Photo Management
   - Photo Product Request Handling
   - User and Role Management

3. **Middleware**:
   - Data Access API
   - Security and Authentication

## 4. Technologies Used
- PHP
- HTML/CSS
- Apache
- MySQLClientAPI

## 5. Installation and Setup
- Install XAMPP.
- Execute SQL scripts from `htdocs\alumni-album\database` for database setup.
- The main entry point is `index.php`.

## 6. User Guide
### Main Screens
1. **Home Page**
2. **Registration**
3. **Login**
4. **Main Catalog View**
5. **Catalog Alternate View**
6. **Orders View**
7. **Photo Sessions View**
8. **Photo Upload**

## 7. Sample Data
- Username
- Password
- Email
- Role
- Major (for alumni users)
- Stream
- Group
- Graduation Year

## 8. Code Overview
### HTML Files
- `export_data.html`
- `index.html`
- `login.html`
- `register.html`
- `request_photoshoot.html`
- `upload_photo.html`

### PHP Files
- `catalog.php`
- `catalog2.php`
- `export_data.php`
- `index.php`
- `login.php`
- `logout.php`
- `order.php`
- `orders.php`
- `photo_details.php`
- `photoshoots.php`
- `profile.php`
- `register.php`
- `request_photoshoot.php`
- `upload_photo.php`

### CSS File
- `style.css`

## 9. Contributions, Limitations, and Future Enhancements
### Contributions
1. **Alumni Data Management**: Developed by Maria and Amira.
2. **Photo Product Export**: Developed by Maria.
3. **Photo Session Management**: Developed by Amira.

### Limitations
- Initial UI simplicity.
- Security needs enhancement.

### Future Enhancements
- API integration for data exchange.
- Improved user interface.
- Enhanced security measures.
