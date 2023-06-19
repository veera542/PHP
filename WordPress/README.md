# Project Name

The "Preschool Registration" project is a WordPress plugin that enables users to sign up for preschool programs.

## Installation

1. Download the plugin ZIP file.
2. Login to your WordPress admin panel.
3. Navigate to "Plugins" > "Add New."
4. Click on the "Upload Plugin" button and select the ZIP file you downloaded.
5. Activate the "Preschool Registration" plugin.

## Dependencies

This plugin relies on the following plugins:

- ACF (Advanced Custom Fields)
- ACF to REST API

Create the four fields Name of preschool(text field), Address(text field), Time of registration during the week(Group field also, need to create subfields), and Location accepting registrations using ACF plugin.
## Usage

To make GET requests to retrieve data, you can use the following API endpoints:

- **GET Request for a specific post:**
  API URL: `http://localwp.com/wp-json/wp/v2/preschool-register/148`
  This request will retrieve the data for post ID 148.

- **GET Request with a datetime query parameter:**
  API URL: `http://localwp.com/wp-json/wp/v2/preschool-register?registration_time=2023-06-19T10:00:00`
  This request accepts a datetime query parameter and returns the relevant data.
