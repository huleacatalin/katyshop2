<?php

/**
 * Copyleft https://sourceforge.net/projects/katyshop2
 * License GNU General Public License version 3 http://www.gnu.org/licenses/
 */
 
// how should dates be displayed on the website?
$this->cfg["date_format"]["en"] = array(
	"date" => "MM/DD/YYYY",
	"time" => "H:i:s",
	"date_time" => "MM/DD/YYYY H:i:s",
	"separator_date" => "/",
	"separator_time" => ":",
	"separator_date_time" => " "
);

$this->cfg["lang"]["en"] = array(
	// activate.php
	"This username could not be found" => 'This username could not be found',
	"Account is active you may now login" => 'Account is active you may now login',
	"This user has been deactivated by an admin and cannot be used for login. Please contact the support department" => 'This user has been deactivated by an admin and cannot be used for login. Please contact the support department',
	"Congratulations, your account has been activated. You may now login." => 'Congratulations, your account has been activated. You may now login.',
	"Wrong activation code" => 'Wrong activation code',
	"User account activation" => 'User account activation',
	"Username" => 'Username',
	"Activation code" => 'Activation code',
	"Activate" => 'Activate',
	
	//address.php
	"My addresses" => 'My addresses',
	"All addresses" => 'All addresses',
	"Primary" => 'Primary',
	"Delivery" => 'Delivery',
	"Invoicing" => 'Invoicing',
	"Add new address" => 'Add new address',
	"Primary address" => 'Primary address',
	"County" => 'County',
	"Please choose" => 'Please choose',
	"City" => 'City',
	"Address" => 'Address',
	"Save" => 'Save',
	"Are you sure you want to delete this address?" => 'Are you sure you want to delete this address?',
	"No address has been found" => 'No address has been found',
	
	// advanced_search.php
	"Advanced search" => 'Advanced search',
	"Informations about the product" => 'Informations about the product',
	"Keywords" => 'Keywords',
	"Manufacturer" => 'Manufacturer',
	"Choose" => 'Choose',
	"Minimal price" => 'Minimal price',
	"Maximum price" => 'Maximum price',
	"Search only in current category and all subcategories" => 'Search only in current category and all subcategories',
	"Search" => 'Search',
	
	// category.php
	"Edit category" => 'Edit category',
	
	// contact.php
	"Contact" => 'Contact',
	"Address" => 'Address',
	"Send a message" => 'Send a message',
	"Name" => 'Name',
	"Email" => 'Email',
	"Subject" => 'Subject',
	"Message" => 'Message',
	"Send" => 'Send',
	
	// forgot_password.php
	"Forgot password?" => 'Forgot password?',
	"Use this form to generate a new password. If you didn't activate the account yet, the activation code will also be sent by email." => "Use this form to generate a new password. If you didn't activate the account yet, the activation code will also be sent by email.",
	
	// how_to_buy.php
	"How to buy" => 'How to buy',
	
	// index.php
	"Products" => 'Products',
	
	// login.php
	"Login" => 'Login',
	"Password" => 'Password',
	"Remember my password" => 'Remember my password',
	"Password or activation code forgotten?" => 'Password or activation code forgotten?',
	"Activation link" => 'Activation link',
	"Register new account" => 'Register new account',
	
	// order.php
	'Step 4: sending the order' => 'Step 4: sending the order',
	'View order' => 'View order',
	"Click here to return to the list of orders" => 'Click here to return to the list of orders',
	"Selected order cannot be displayed because it doesn't belong to you" => "Selected order cannot be displayed because it doesn't belong to you",
	"The order is empty" => 'The order is empty',
	"Send the order" => 'Send the order',
	"Order code" => 'Order code',
	"click here to view proforma invoice" => 'click here to view proforma invoice',
	"Title" => 'Title',
	"Date ordered" => 'Date ordered',
	"Status updated date" => 'Status updated date',
	"Status" => 'Status',
	"Order products" => 'Order products',
	"No." => 'No.',
	"Product" => 'Product',
	"M. U." => 'M. U.',
	"Quantity" => 'Quantity',
	"Unit price" => 'Unit price',
	"TOTAL" => 'TOTAL',
	"Update products" => 'Update products',
	"Delivery address" => 'Delivery address',
	"Invoicing address" => 'Invoicing address',
	"Change invoicing address" => 'Change invoicing address',
	"Click here to send the order to the shop" => 'Click here to send the order to the shop',
	"Back" => 'Back',
	"Click here to change the invoicing address" => 'Click here to change the invoicing address',
	
	// orders_list.php
	"My orders" => 'My orders',
	"Select by status" => 'Select by status',
	"All" => 'All',
	"Code" => 'Code',
	"ID" => 'ID',
	"Total value" => 'Total value',
	"Could not find any order for your search criteria." => 'Could not find any order for your search criteria.',
	
	// payment_and_delivery.php
	"Payment and delivery" => 'Payment and delivery',
	"How do I pay?" => 'How do I pay?',
	
	// product.php
	"Manufacturer" => 'Manufacturer',
	"Edit product" => 'Edit product',
	"Add to the cart" => 'Add to the cart',
	"Description" => 'Description',
	"Technical details" => 'Technical details',
	'Comments' => 'Comments',
	"You must login to post a comment" => "You must login to post a comment",
	"Post a comment" => "Post a comment",
	"Are you sure you want to delete this comment?" => "Are you sure you want to delete this comment?",
	"delete" => "delete",
	
	// profile.php
	"Profile" => 'Profile',
	"You have no addresses." => 'You have no addresses.',
	"Click here to add a new address" => 'Click here to add a new address',
	"Click here to see the list of addresses" => 'Click here to see the list of addresses',
	"Login info" => 'Login info',
	"Click here to change the password" => 'Click here to change the password',
	"Old password" => 'Old password',
	"New password" => 'New password',
	"Confirm password" => 'Confirm password',
	"Change the password" => 'Change the password',
	"Account type" => 'Account type',
	"Registered date" => 'Registered date',
	"Personal info" => 'Personal info',
	"Gender" => 'Gender',
	"Miss" => 'Miss',
	"Mister" => 'Mister',
	"First name" => 'First name',
	"Last name" => 'Last name',
	"Birth date" => 'Birth date',
	"Phone" => 'Phone',
	"Company info" => 'Company info',
	"Company name" => 'Company name',
	"Tax code" => 'Tax code',
	"Bank" => 'Bank',
	"IBAN" => 'IBAN',
	"Fax" => 'Fax',
	"Update" => 'Update',
	
	// proforma.php
	"Proforma invoice cannot be displayed because it doesn't belong to you" => "Proforma invoice cannot be displayed because it doesn't belong to you",
	"Could not find the file that contains proforma invoice informations" => 'Could not find the file that contains proforma invoice informations',
	
	// register.php
	"New account registration" => 'New account registration',
	"Person" => 'Person',
	"Company" => 'Company',
	"Register" => 'Register',
	
	// search.php
	"Search results" => 'Search results',
	
	// shopping_cart.php
	"Processing order: step 1" => 'Processing order: step 1',
	"Shopping cart" => 'Shopping cart',
	"The cart is empty" => 'The cart is empty',
	"Date" => 'Date',
	"Value" => "Value",
	
	// shopping_cart_address.php
	"Step" => 'Step',
	"Select delivery address" => 'Select delivery address',
	"Select invoicing address" => 'Select invoicing address',
	"delivery" => 'delivery',
	"invoicing" => 'invoicing',
	"Select" => 'Select',
	"No delivery address could be found." => 'No delivery address could be found.',
	"Click here" => 'Click here',
	"to add a new delivery address in your address book." => 'to add a new delivery address in your address book.',
	"No invoicing address could be found." => 'No invoicing address could be found.',
	"to add a new invoicing address in your address book." => 'to add a new invoicing address in your address book.',
	
	// terms.php
	"Terms and conditions" => 'Terms and conditions',
	
	// formparser/address.php
	"Admin accounts cannot have addresses" => 'Admin accounts cannot have addresses',
	"Address has been saved" => 'Address has been saved',
	"Our server could not understand the request sent by your browser" => 'Our server could not understand the request sent by your browser',
	"Could not find address to delete" => 'Could not find address to delete',
	"That address doesn't belong to you" => "That address doesn't belong to you",
	"Address has been deleted" => 'Address has been deleted',
	
	// formparser/contact_message.php
	"Message has been sent" => 'Message has been sent',
	
	// formparser/order.php
	"Could not find product to add to the cart" => 'Could not find product to add to the cart',
	"You must login in order to send the order" => 'You must login in order to send the order',
	"Admin accounts cannot send orders" => 'Admin accounts cannot send orders',
	"Could not find one of the products to add to the cart" => 'Could not find one of the products to add to the cart',
	"You must login to send the order" => 'You must login to send the order',
	"Could not find the delivery address selected by you" => 'Could not find the delivery address selected by you',
	"The selected address doesn't belong to you" => "The selected address doesn't belong to you",
	"The selected address is not a delivery address" => 'The selected address is not a delivery address',
	"You must login before sending the order" => 'You must login before sending the order',
	"Could not find invoice address selected by you" => 'Could not find invoice address selected by you',
	"The selected address is not a invoicing address" => 'The selected address is not a invoicing address',
	"You must login to send the order" => 'You must login to send the order',
	"Order has been sent" => 'Order has been sent',
	
	// formparser/user.php
	"You may not use the register form because you are logged in" => 'You may not use the register form because you are logged in',
	"Please choose a valid account type" => 'Please choose a valid account type',
	"Your browser sent a request that our server could not understand" => 'Your browser sent a request that our server could not understand',
	"Our mail server doesn't work properly for the moment, the mail with activation code could not be sent" => "Our mail server doesn't work properly for the moment, the mail with activation code could not be sent",
	"Your account has been created" => 'Your account has been created',
	"You are already authenticated" => 'You are already authenticated',
	"You logged in" => 'You logged in',
	"Login failed" => 'Login failed',
	"Your profile has been updated" => 'Your profile has been updated',
	"This username doesn't exist" => "This username doesn't exist",
	"Please enter email address" => 'Please enter email address',
	"Email address is not correct" => 'Email address is not correct',
	"A new random password has been generated" => 'A new random password has been generated',
	"Please check your email address to receive the new password, you will be able to use this new password to authenticate yourself." => 'Please check your email address to receive the new password, you will be able to use this new password to authenticate yourself.',
	"Our mail server doesn't work properly, the mail with random password could not be sent. Please try again later." => "Our mail server doesn't work properly, the mail with random password could not be sent. Please try again later.",
	
	// formparser/comment.php
	"Comment sent" => "Comment sent",
	"Comment deleted" => "Comment deleted",
	
	// includes/footer.php
	"Admin" => 'Admin',
	"Logout" => 'Logout',
	"New account" => 'New account',
	
	// includes/functions.php
	"order ascending by " => 'order ascending by ',
	"order descending by " => 'order descending by ',
	"Page: " => 'Page: ',
	'Previous' => 'Previous',
	"Next" => 'Next',
	'Rows per page' => 'Rows per page',
	
	// includes/generate_proforma.php
	"Could not find the order to generate proforma invoice for" => 'Could not find the order to generate proforma invoice for',
	"The selected order cannot be shown because it doesn't belong to you" => "The selected order cannot be shown because it doesn't belong to you",
	"proforma invoice" => 'proforma invoice',
	"Proforma code" => 'Proforma code',
	"Date issued" => 'Date issued',
	"Customer informations" => 'Customer informations',
	"Customer" => 'Customer',
	"Customer ID" => 'Customer ID',
	"Total to pay" => 'Total to pay',
	
	// includes/header.php
	"advanced" => 'advanced',
	"Payment" => 'Payment',
	
	// includes/products_list.php
	"Price" => 'Price',
	
	// includes/right.php
	"Welcome" => 'Welcome',
	"my account" => 'my account',
	
	// includes/shopping_cart_box.php
	"View cart" => "View cart",
	
	// classes/common/UploadFile.php
	"There was an error while trying to upload the file" => 'There was an error while trying to upload the file',
	"Temporary filename must have between 5 and 255 characters" => 'Temporary filename must have between 5 and 255 characters',
	"New filename must have between 5 and 255 characters" => 'New filename must have between 5 and 255 characters',
	"Could not find FINAL_DIR as a directory to use it" => 'Could not find FINAL_DIR as a directory to use it',
	"Could not find TEMP_DIR as a directory to use it" => 'Could not find TEMP_DIR as a directory to use it',
	"The file you uploaded is not an image, please try again" => 'The file you uploaded is not an image, please try again',
	"Cannot use temporary upload method because TEMP_DIR is not set" => 'Cannot use temporary upload method because TEMP_DIR is not set',
	"Could not process the image you uploaded" => 'Could not process the image you uploaded',
	"Cannot use commit() because TEMP_DIR is not set" => 'Cannot use commit() because TEMP_DIR is not set',
	
	// classes/tools/AppMailAgent.php
	"Hello" => 'Hello',
	"Welcome to " => 'Welcome to ',
	", thank you for your registration" => ', thank you for your registration',
	"Please click the following link in order to activate your account" => 'Please click the following link in order to activate your account',
	"password changed" => 'password changed',
	"Your password has been changed" => 'Your password has been changed',
	"This email is sent automatically because the 'forgot password' form on our site was used to change your password. You can see this form here" => "This email is sent automatically because the 'forgot password' form on our site was used to change your password. You can see this form here",
	"You may now click on this link to login using the new random generated password" => 'You may now click on this link to login using the new random generated password',
	"After you login you can change your profile preferences here" => 'After you login you can change your profile preferences here',
	"new order" => 'new order',
	" New order" => ' New order',
	"User " => 'User ',
	"has sent a new order with total value" => 'has sent a new order with total value',
	"Ordered products are" => 'Ordered products are',
	"The proforma invoice is attached" => 'The proforma invoice is attached',
	"order status update" => 'order status update',
	"Order status changed" => 'Order status changed',
	"The status of the order" => 'The status of the order',
	"sent by user" => 'sent by user',
	"has changed" => 'has changed',
	"The old status was" => 'The old status was',
	"and now the new status is" => 'and now the new status is',
	"The proforma invoice is attached to this mail" => 'The proforma invoice is attached to this mail',
	"contact message" => 'contact message',
	'Visitor' => 'Visitor',
	'Subject' => 'Subject',
	'Message' => 'Message',
	'User details' => 'User details',
	
	// classes/logic/Visitor.php
	"This username does not exist" => 'This username does not exist',
	"Unauthenticated user with IP address" => 'Unauthenticated user with IP address',
	
	// classes/logic/UserPerson.php
	"Please choose a valid gender" => 'Please choose a valid gender',
	"First name must have between 3 and 20 characters" => 'First name must have between 3 and 20 characters',
	"Name must have between 3 and 20 characters" => 'Name must have between 3 and 20 characters',
	"Phone must have maximum 20 characters" => 'Phone must have maximum 20 characters',
	"Last name must have between 3 and 20 characters" => 'Last name must have between 3 and 20 characters',
	"Phone must have between 3 and 20 characters" => 'Phone must have between 3 and 20 characters',
	"Person account with details" => 'Person account with details',
	"Birth date" => 'Birth date',
	
	// classes/logic/UserCompany.php
	"Company phone" => 'Company phone',
	"Company email" => 'Company email',
	"Company account with details" => 'Company account with details',
	"Company fax" => 'Company fax',
	"must have maximum 177 characters" => "must have maximum 177 characters",
	
	// classes/logic/User.php
	"Username must only have letters, numbers or underscore characters" => 'Username must only have letters, numbers or underscore characters',
	"Username must have between 5 and 20 characters" => 'Username must have between 5 and 20 characters',
	"Password must have between 5 and 255 characters" => 'Password must have between 5 and 255 characters',
	"Please choose a valid account type" => 'Please choose a valid account type',
	"The 2 passwords do not match" => 'The 2 passwords do not match',
	"This username is already taken, please try again" => 'This username is already taken, please try again',
	"Email address is not valid" => 'Email address is not valid',
	"This email address has already been used to create another account" => 'This email address has already been used to create another account',
	"Old password is not correct" => 'Old password is not correct',
	"New password and confirmation password are not the same" => 'New password and confirmation password are not the same',
	"New password must have between 5 and 255 characters" => 'New password must have between 5 and 255 characters',
	"Password is not correct" => 'Password is not correct',
	"You must first activate your account before you can login" => 'You must first activate your account before you can login',
	"Your account has been deactivated, please contact our support personnel for more details" => 'Your account has been deactivated, please contact our support personnel for more details',
	"customer ID" => 'customer ID',
	"User account, with IP address" => 'User account, with IP address',
	"ID" => 'ID',
	"Active account" => 'Active account',
	
	// classes/logic/ProductImage.php
	"Filename must have between 5 and 255 characters" => 'Filename must have between 5 and 255 characters',
	'Product for this image does not exist' => 'Product for this image does not exist',
	"Image uploaded" => 'Image uploaded',
	
	// classes/logic/Product.php
	"id property of Product object must be integer" => 'id property of Product object must be integer',
	"id_category property of Product object must be integer" => 'id_category property of Product object must be integer',
	"Product's price must be a strict positive real number" => "Product's price must be a strict positive real number",
	"Product's position must be strict positive integer" => "Product's position must be strict positive integer",
	"Title must have between 3 and 255 characters" => 'Title must have between 3 and 255 characters',
	"Uploaded file is not an image" => 'Uploaded file is not an image',
	"Product creation date is not valid" => 'Product creation date is not valid',
	"'active' property of Product object can only be 0 or 1" => "'active' property of Product object can only be 0 or 1",
	"Could not find product to update" => 'Could not find product to update',
	"Could not find parent category" => 'Could not find parent category',
	"Please choose the measuring unit" => 'Please choose the measuring unit',
	"There is already another product with this title" => 'There is already another product with this title',
	"Could not find the selected manufacturer for this product" => 'Could not find the selected manufacturer for this product',
	"pieces" => 'pieces',
	"kg" => 'kg',
	
	// classes/logic/Comment.php
	"Comment must have between 3 and 1000 characters" => 'Comment must have between 3 and 1000 characters',
	'Product of this comment does not exist' => 'Product of this comment does not exist',
	'User of this comment does not exist' => 'User of this comment does not exist',
	
	// classes/logic/OrderProduct.php
	"id_order property of OrderProduct object must be positive integer" => 'id_order property of OrderProduct object must be positive integer',
	"An order can hold between 1 and 50 products" => 'An order can hold between 1 and 50 products',
	"id_product property must be a positive integer" => 'id_product property must be a positive integer',
	"Products name must have between 3 and 255 characters" => 'Products name must have between 3 and 255 characters',
	"Price must be positive integer" => 'Price must be positive integer',
	"Quantity is not correct" => 'Quantity is not correct',
	"Total value of the order must be positive" => 'Total value of the order must be positive',
	"Product named" => 'Product named',
	"from the position" => 'from the position',
	"doesn't exist in our database" => "doesn't exist in our database",
	"from the order cannot be ordered because it is no longer active on the website" => 'from the order cannot be ordered because it is no longer active on the website',
	
	// classes/logic/Order.php
	"New order" => 'New order',
	"id property of Order object must be positive integer" => 'id property of Order object must be positive integer',
	"Order title must have between 3 and 255 characters" => 'Order title must have between 3 and 255 characters',
	"id_user property of Order object must be positive integer" => 'id_user property of Order object must be positive integer',
	"Order status is not valid" => 'Order status is not valid',
	"Order date is not valid" => 'Order date is not valid',
	"Updated order date is not valid" => 'Updated order date is not valid',
	"Total value of the order must be positive" => 'Total value of the order must be positive',
	"The order is empty" => 'The order is empty',
	"An order line is not identified as a product" => 'An order line is not identified as a product',
	"Only Person or Company users may issue orders" => 'Only Person or Company users may issue orders',
	"Delivery address must have between 10 and 1000 characters" => 'Delivery address must have between 10 and 1000 characters',
	"The selected delivery address does not belong to the user who issued the order" => 'The selected delivery address does not belong to the user who issued the order',
	"Invoicing address must have between 10 and 1000 characters" => 'Invoicing address must have between 10 and 1000 characters',
	"The selected invoicing address doesn't belong to user who issued the order" => "The selected invoicing address doesn't belong to user who issued the order",
	// Order statuses:
	"in cart" => 'in cart',
	"sent" => 'sent',
	"working on it" => 'working on it',
	"rejected" => 'rejected',
	"delivered" => 'delivered',
	"payed" => 'payed',
	"Could not write the proforma file for" => 'Could not write the proforma file for',
	"because there is already another file with the same name" => 'because there is already another file with the same name',
	"There was an error while trying to write the file" => 'There was an error while trying to write the file',
	
	// classes/logic/Manufacturer.php
	"id property of Manufacturer object must be positive integer" => 'id property of Manufacturer object must be positive integer',
	"Manufacturer title must have between 3 and 255 characters" => 'Manufacturer title must have between 3 and 255 characters',
	"Manufacturer description must not have more than 500 characters" => 'Manufacturer description must not have more than 500 characters',
	"Could not find the manufacturer to edit" => 'Could not find the manufacturer to edit',
	"There is already another manufacturer with this title" => 'There is already another manufacturer with this title',
	
	// classes/logic/Category.php
	"The ID property of Category object must be integer" => 'The ID property of Category object must be integer',
	"The id_parent property of Category object must be integer" => 'The id_parent property of Category object must be integer',
	"A category cannot be it's own parent" => "A category cannot be it's own parent",
	"Category position must be positive integer" => 'Category position must be positive integer',
	"Title must have between 3 and 255 characters" => 'Title must have between 3 and 255 characters',
	"Uploaded file is not an image" => 'Uploaded file is not an image',
	"Category creation date is not valid" => 'Category creation date is not valid',
	"The 'active' property of Category object can only be 0 or 1" => "The 'active' property of Category object can only be 0 or 1",
	"Could not find category to update" => 'Could not find category to update',
	"Could not find parent category" => 'Could not find parent category',
	"Category cannot be moved into a subcategory of it's own" => "Category cannot be moved into a subcategory of it's own",
	"There is already another category with this title" => 'There is already another category with this title',
	"Maximum possible value for position is" => 'Maximum possible value for position is',
	
	// classes/logic/ContactMessage.php
	"Name must have between 3 and 177 characters" => 'Name must have between 3 and 177 characters',
	"Email address must have between 3 and 177 characters" => 'Email address must have between 3 and 177 characters',
	"Email address is not valid" => 'Email address is not valid',
	"Subject must have between 3 and 255 characters" => 'Subject must have between 3 and 255 characters',
	"Message must have between 3 and 1000 characters" => 'Message must have between 3 and 1000 characters',
	
	// classes/logic/Address.php
	"There is no user having this address" => 'There is no user having this address',
	"The county must have between 3 and 177 characters" => 'The county must have between 3 and 177 characters',
	"The city must have between 3 and 177 characters" => 'The city must have between 3 and 177 characters',
	"The address must have between 3 and 1000 characters" => 'The address must have between 3 and 1000 characters',
	"Could not find this address to update it" => 'Could not find this address to update it',
	"This address doesn't belong to you" => "This address doesn't belong to you",
	
	// admin/user.php
	"Users admin" => 'Users admin',
	"view the addresses of this user" => 'view the addresses of this user',
	"Login informations" => 'Login informations',
	"Active" => 'Active',
	"deactivate" => 'deactivate',
	"activate" => 'activate',
	"Are you sure you want to delete this user?" => 'Are you sure you want to delete this user?',
	"Create admin account" => 'Create admin account',
	"Create new admin account" => 'Create new admin account',
	"username" => 'username',
	"email" => 'email',
	"active" => 'active',
	"account type" => 'account type',
	'registered date' => 'registered date',
	"action" => 'action',
	"Yes" => 'Yes',
	"No" => 'No',
	"Could not find any users for your search criteria" => 'Could not find any users for your search criteria',
	
	// admin/proforma.php
	"Could not find the file that contains proforma invoice" => 'Could not find the file that contains proforma invoice',
	
	// admin/product.php
	"Products admin" => 'Products admin',
	"Parent category" => 'Parent category',
	"Delete product" => 'Delete product',
	"Product is active" => 'Product is active',
	"View the product on the public site" => 'View the product on the public site',
	"Product is not active" => 'Product is not active',
	"Edit product " => 'Edit product ',
	"Add a new product" => 'Add a new product',
	"Measuring unit" => 'Measuring unit',
	"Position" => 'Position',
	"Short description (appeares to the list of products)" => 'Short description (appeares to the list of products)',
	"Content (detailed description, appeares to the product details page)" => 'Content (detailed description, appeares to the product details page)',
	"Image" => 'Image',
	"click here to change the image" => 'click here to change the image',
	"Images" => 'Images',
	"New images (click to upload pictures)" => 'New images (click to upload pictures)',
	"Cancel" => 'Cancel',
	
	// admin/manufacturer.php
	"Manufacturers admin" => 'Manufacturers admin',
	"Add a new manufacturer" => 'Add a new manufacturer',
	"Edit manufacturer details" => 'Edit manufacturer details',
	"Back to the manufacturers list" => 'Back to the manufacturers list',
	"Manufacturers list" => 'Manufacturers list',
	"click here to add a new manufacturer" => 'click here to add a new manufacturer',
	"There are no manufacturers in the list" => 'There are no manufacturers in the list',
	
	// admin/order.php
	"Orders admin" => 'Orders admin',
	"Click here to return to the list of orders" => 'Click here to return to the list of orders',
	"Order is empty" => 'Order is empty',
	"click here to see proforma invoice" => 'click here to see proforma invoice',
	"Date sent" => 'Date sent',
	"Date updated" => 'Date updated',
	"click here to change status" => 'click here to change status',
	"Warning! Delivery address, invoicing address and users details have been registered at the moment when he sent the order. It is possible that in the mean time he changed his addresses or his users details using the profile page." => 'Warning! Delivery address, invoicing address and users details have been registered at the moment when he sent the order. It is possible that in the mean time he changed his addresses or his users details using the profile page.',
	"However, even he changed his data, these are the original informations we knew about him at the moment he sent the order." => 'However, even he changed his data, these are the original informations we knew about him at the moment he sent the order.',
	"User details" => 'User details',
	"Orders list" => 'Orders list',
	"User" => 'User',
	"Could not find any order for your search criteria." => 'Could not find any order for your search criteria.',
	
	// admin/index.php
	"Users" => 'Users',
	"Orders" => 'Orders',
	"Manufacturers" => 'Manufacturers',
	"Messages" => 'Messages',
	"Categories" => 'Categories',
	
	// admin/contact_message.php
	"Messages received from visitors" => 'Messages received from visitors',
	"Message could not be found" => 'Message could not be found',
	"View message" => 'View message',
	"Back to the list of messages" => 'Back to the list of messages',
	"Visitor name" => 'Visitor name',
	"Visitor email" => 'Visitor email',
	"Warning! User details have been registered at the moment when the message has been sent. It is possible that in the mean time he changed these informations using the profile form." => 'Warning! User details have been registered at the moment when the message has been sent. It is possible that in the mean time he changed these informations using the profile form.',
	"However, even he changed these data, these are the original informations we knew about him at the moment he sent the message." => 'However, even he changed these data, these are the original informations we knew about him at the moment he sent the message.',
	"No message has been found for your search criteria." => 'No message has been found for your search criteria.',
	
	// admin/category.php
	"Categories administration" => 'Categories administration',
	"Root category for products in your store" => 'Root category for products in your store',
	"Add a new category" => 'Add a new category',
	"Add a new product" => 'Add a new product',
	"Delete category" => 'Delete category',
	"Category is active" => 'Category is active',
	"View category on the public site" => 'View category on the public site',
	"Category is not active" => 'Category is not active',
	"Add a new category" => 'Add a new category',
	"Picture" => 'Picture',
	"click here to change picture" => 'click here to change picture',
	"Subcategories from" => 'Subcategories from',
	"Actions" => 'Actions',
	"Created date" => 'Created date',
	"category is active on the public site" => 'category is active on the public site',
	
	// admin/address.php
	"View users addresses" => 'View users addresses',
	"No address has been found" => 'No address has been found',
	
	// admin/formparser/user.php
	"Admin account has been created" => 'Admin account has been created',
	"Could not find the user to delete" => 'Could not find the user to delete',
	"The user has been deleted" => 'The user has been deleted',
	
	// admin/formparser/product_image.php
	"Could not find product image to change it's position" => "Could not find product image to change it's position",
	"You must specify the direction how to change the position" => 'You must specify the direction how to change the position',
	"Product image's position has been updated" => "Product image's position has been updated",
	
	// admin/formparser/product.php
	"Product has been saved" => 'Product has been saved',
	"Image changed" => 'Image changed',
	"Could not find product to delete" => 'Could not find product to delete',
	"Product has been deleted" => 'Product has been deleted',
	"Could not find product to change it's position" => "Could not find product to change it's position",
	"You must specify the direction how to change the position" => 'You must specify the direction how to change the position',
	"Product's position has been updated" => "Product's position has been updated",
	"Could not find product to activate / deactivate" => 'Could not find product to activate / deactivate',
	"Product has been activated" => 'Product has been activated',
	"Product has been deactivated" => 'Product has been deactivated',
	
	// admin/formparser/order.php
	"Could not find the order to change status" => 'Could not find the order to change status',
	"Please choose a valid status for the order" => 'Please choose a valid status for the order',
	"The order already sent cannot have the 'in cart' status" => "The order already sent cannot have the 'in cart' status",
	"Order status has been changed" => 'Order status has been changed',
	
	// admin/formparser/manufacturer.php
	"Manufacturer has been saved" => 'Manufacturer has been saved',
	"Could not find manufacturer to delete" => 'Could not find manufacturer to delete',
	"Manufacturer deleted" => 'Manufacturer deleted',
	
	// admin/formparser/category.php
	"Category saved" => 'Category saved',
	"Could not find category to delete" => 'Could not find category to delete',
	"Category has been deleted" => 'Category has been deleted',
	"Could not find the category to change it's position" => "Could not find the category to change it's position",
	"You must specify the direction how to change the position" => 'You must specify the direction how to change the position',
	"Category position has been changed" => 'Category position has been changed',
	"Could not find category to activate / deactivate" => 'Could not find category to activate / deactivate',
	"Category has been activated" => 'Category has been activated',
	"Category has been deactivated" => 'Category has been deactivated',
	
	// admin/includes/products_list.php
	"Products from" => 'Products from',
	"product is active on the public site" => 'product is active on the public site',
	"product is not active on the public site" => 'product is not active on the public site'
);

?>