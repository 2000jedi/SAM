SAM
====
System of Assignment Management

The MIT License (MIT)
---- 
Copyright (c) [2015] [Computerization]

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.



The structure of the code
---- 
1.  files/
	- All the static resources needed
2.  framework/
	- All the frameworks that are either from prominent developers or files I used in other projects.
	-  fix/
		- Fix the stupid data input of safari
	-  geodesic/
		- Sam's UI Framework
	-  googlefont/
		- Static Google Fonts file
	-  js/
		- Javascript frameworks
		-  form.js
			- jQuery form
		-  jq.js
			- jQuery framework
	-  pure/
		- UI framework from Yahoo with some modification from Sam
	-  sam/
		- UI framework created by Jedi and DavidZYC
3.  modules/
	- All the php files used to process ajax requests
	- Some folders have a 'ManipulateXXXClass.php', which shall contain all the process functions and their documents.
	-  assignments/
		- Used to deal with the request related to assignments
		-  ManipulateAssignmentClass.php
			- Check the document in file
			- **It behaves differently on local development and SAE**
		-  UnitAssignment.php
			- A class created mainly for JSON object construction
		-  addAssignment.php
			- Used to add a new assignment
		-  classLoadAssignment.php
			- Used to load assignments for a class
		-  studentLoadAssignment.php
			- Used to load assignments for a student
		-  markCompletion.php
			- Used to mark an assignment as completed
		-  markUnCompletion.php
			- Used to mark an assignment as uncompleted
		-  updateAssignment.php
			- Used to update the content of an assignment
		-  deleteAssignment.php
			- Used to delete an assignment
	-  class/
		- Used to deal with the request related to classes
		-  ManipulateClassClass.php
			- Check the document in file
		-  UnitClass.php
			- A class created mainly for JSON object construction
		-  createClass.php
			- Used to create a class
		-  deleteClass.php
			- Used to delete a class
		-  changeClassMembers.php
			- Used by admin to change class members of a class
		-  loadClassMembers.php
			- Used to load class members of a class
		-  loadClass.php
			- Used to load class for students or teachers
	-  client/
		- It is used for client on iOS and Android
		-  classes/
			- Classes for calling
			-  checkID.php
				- Check the validity of user on the client side
			-  Device.php
				- A class for a device. Programmers can:
					- Update its info
					- Push notification
				- **It behaves differently on local development and SAE**
			-  updateToken.php
				- Update token for pushing notification
		-  v1/assignment/
			- Deprecated
			- DON'T USE
			- Used by Client V1
			-  getNotification.php
			-  updateNotificationRaw.php
	-  common/
		- Common functions that is essential to a server side framework
		-  basic.php
			- It contains function to process basic operations
		-  crypto.php
			- It is used to encrypt/decrypt/hash strings
		-  downloader.php
			- Once visited with appropriate parameters, it will download the designated file.
			- **It behaves differently on local development and SAE**
	-  database/
		- It is used to deal with the database
		-  connect.php
			- Used to connect to database
			- **It behaves differently on local development and SAE**
	-  security/
		- Used to enhance the security of the system
		- Used to find the cracker when the system is compromised
		-  loadIPAddress.php
			- It loads all the IPs that once appeared in the system
		-  Security.php
			- It is a class that provides bridge to database for security
	-  test/
		- Used to test
		-  test.php
			- only file used to test functions
	-  user/
		- Used to deal with the request related to users
		-  User.php
			- A user class that provides function to update its info
		-  UserInfo.php
			- A class created mainly for JSON object construction
		-  checkValid.php
			- Used to check the identity of a user
		-  ManipulateUserClass.php
			- Check the document in file
			- **It behaves differently on local development and SAE**
		-  create.php
			- Used to create a single user
		-  massiveCreateUser.php
			- Used to create users for a class
		-  listUserInfo.php
			- Used to list all the user info
		-  listUserWithDefaultPassword.php
			- Used to list all the user info of whom has default password
		-  forgotPasswordSendMail.php
			- Used to send mail to those who forgot password
		-  forgotPassword.php
			- Used to respond to the reset password command
		-  changeEmail.php
			- Used to change email
		-  changePassword.php
			- Used to changePassword
4.  template/
	- Template that would be requested
	-  pages/
		- Store the pages that would be repeatedly used in apps
		-  settings.html
			- Settings page
	-  scripts/
		1.  assignment.js
			- Deal with assignments
		2.  base.js
			- Deal with basic level functions used
		3.  class.js
			- Deal with class
		4.  settings.js
			- Deal with settings
		5.  waterfall.js
			- The waterfall UI in the stream view of student side
	-  sources/
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

