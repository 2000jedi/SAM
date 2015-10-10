SAM
====
- System of Assignment Management
----------------------------------

The structure of the code
-------------------------
1.  files/
    - All the static resources needed
2.  framework/
    - All the frameworks that are either from prominent developers or files I used in other projects.
    1.  fix/
        - Fix the stupid data input of safari
    2.  geodesic/
        - Sam's UI Framework
    3.  googlefont/
        - Static Google Fonts file
    4.  js/
        - Javascript frameworks
        2.4.1.  form.js
            - jQuery form
        2.4.2.  jq.js
            - jQuery framework
    5.  pure/
        - UI framework from Yahoo with some modification from Sam
3.  modules/
    - All the php files used to process ajax requests
    - Some folders have a 'ManipulateXXXClass.php', which shall contain all the process functions and their documents.
    3.1.  assignments/
        - Used to deal with the request related to assignments
        3.1.1.  ManipulateAssignmentClass.php
            - Check the document in file
            - *It behaves differently on local development and SAE*
        3.1.2.  UnitAssignment.php
            - A class created mainly for JSON object construction
        3.1.3.  addAssignment.php
            - Used to add a new assignment
        3.1.4.  classLoadAssignment.php
            - Used to load assignments for a class
        3.1.5.  studentLoadAssignment.php
            - Used to load assignments for a student
        3.1.6.  markCompletion.php
            - Used to mark an assignment as completed
        3.1.7.  markUnCompletion.php
            - Used to mark an assignment as uncompleted
        3.1.8.  updateAssignment.php
            - Used to update the content of an assignment
        3.1.9.  deleteAssignment.php
            - Used to delete an assignment
    3.2.  class/
        - Used to deal with the request related to classes
        3.2.1.  ManipulateClassClass.php
            - Check the document in file
        3.2.2.  UnitClass.php
            - A class created mainly for JSON object construction
        3.2.3.  createClass.php
            - Used to create a class
        3.2.4.  deleteClass.php
            - Used to delete a class
        3.2.5.  changeClassMembers.php
            - Used by admin to change class members of a class
        3.2.6.  loadClassMembers.php
            - Used to load class members of a class
        3.2.7.  loadClass.php
            - Used to load class for students or teachers
    3.3.  client/
        - It is used for client on iOS and Android
        3.3.1.  classes/
            - Classes for calling
            3.3.1.1.  checkID.php
                - Check the validity of user on the client side
            3.3.1.2.  Device.php
                - A class for a device. Programmers can:
                    - Update its info
                    - Push notification
                - *It behaves differently on local development and SAE*
            3.3.1.3.  updateToken.php
                - Update token for pushing notification
        3.3.2.  v1/assignment/
            - Deprecated
            - DON'T USE
            - Used by Client V1
            3.3.2.1.  getNotification.php
            3.3.2.2.  updateNotificationRaw.php
    3.4.  common/
        - Common functions that is essential to a server side framework
        3.4.1.  basic.php
            - It contains function to process basic operations
        3.4.2.  crypto.php
            - It is used to encrypt/decrypt/hash strings
        3.4.3.  downloader.php
            - Once visited with appropriate parameters, it will download the designated file.
            - *It behaves differently on local development and SAE*
    3.5.  database/
        - It is used to deal with the database
        3.5.1.  connect.php
            - Used to connect to database
            - *It behaves differently on local development and SAE*
    3.6.  security/
        - Used to enhance the security of the system
        - Used to find the cracker when the system is compromised
        3.6.1.  loadIPAddress.php
            - It loads all the IPs that once appeared in the system
        3.6.2.  Security.php
            - It is a class that provides bridge to database for security
    3.7.  test/
        - Used to test
        3.7.1.  test.php
            - only file used to test functions
    3.8.  user/
        - Used to deal with the request related to users
        3.8.1.  User.php
            - A user class that provides function to update its info
        3.8.2.  UserInfo.php
            - A class created mainly for JSON object construction
        3.8.3.  checkValid.php
            - Used to check the identity of a user
        3.8.4.  ManipulateUserClass.php
            - Check the document in file
        3.8.5.  create.php
            - Used to create a single user
        3.8.6.  massiveCreateUser.php
            - Used to create users for a class
        3.8.7.  listUserInfo.php
            - Used to list all the user info
        3.8.8.  listUserWithDefaultPassword.php
            - Used to list all the user info of whom has default password
        3.8.9.  forgotPasswordSendMail.php
            - Used to send mail to those who forgot password
            - *It behaves differently on local development and SAE*
        3.8.10.  forgotPassword.php
            - Used to respond to the reset password command
        3.8.11.  changeEmail.php
            - Used to change email
        3.8.12.  changePassword.php
            - Used to changePassword
4.  template/
    4.1.  pages/
        - Store the pages that would be repeatedly used in apps
        4.1.1.  settings.html
            - Settings page
    4.2.  scripts/
        4.2.1.  assignment.js
            - Deal with assignments
        4.2.2.  base.js
            - Deal with basic level functions used
        4.2.3.  class.js
            - Deal with class
        4.2.4.  settings.js
            - Deal with settings
        4.2.5.  waterfall.js
            - The waterfall UI in the stream view of student side
    4.3.  sources/
        - Not used yet
5.  admin.php
    - The admin side
6.  student.php
    - The student side
7.  teacher.php
    - The teacher side
8.  config.php
    - Configuration. It includes:
        - App Name
        - Mode of the app (local development or SAE)
9.  login.php
    - Used to display login page and process login request
10.  index.php
    - Automatically loads student.php or teacher.php for different type of users


