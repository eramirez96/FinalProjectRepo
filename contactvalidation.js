/******f**********
    
    Final Project
    Name: Elijah Ramirez
    Date: December 4, 2019
    Description: Form Validation JavaScript

*****************/

function trim(str) 
{
	// Uses a regex to remove spaces from a string.
	return str.replace(/^\s+|\s+$/g,"");
}

function validate(e)
{
	hideErrors();

	if (formHasErrors()){
		e.preventDefault();

		return false;
	}

	return true;
}

function resetForm(e)
{
	if ( confirm('Clear?') )
	{
		// Ensure all error fields are hidden
		hideErrors();
		
		// Set focus to the first text field on the page
		document.getElementById("name").focus();
		
		// When using onReset="resetForm()" in markup, returning true will allow
		// the form to reset
		return true;
	}

	// Prevents the form from resetting
	e.preventDefault();
	
	// When using onReset="resetForm()" in markup, returning false would prevent
	// the form from resetting
	return false;	
}

/*
 * Does all the error checking for the form.
 *
 * return   True if an error was found; False if no errors were found
 */
function formHasErrors()
{
	var errorFlag = false;

	//below is a check for blank text fields
	var requiredTextFields = ["name", "phonenum", "email"];

	for (var i = 0; i < requiredTextFields.length; i++) {

		var textField = document.getElementById(requiredTextFields[i]);

		if (!formFieldHasInput(textField)){

			document.getElementById(requiredTextFields[i] + "_error").style.display = "block";

			if(!errorFlag){
				textField.focus();
				textField.select();
			}
			errorFlag = true;
		}
	}

	//phone number error check
	var phoneno = /^\d{10}$/;
   	if (!phonenum.value.match(phoneno)){

   		document.getElementById("phonenumformat_error").style.display = "block";

		if(!errorFlag){
			textField.focus();
			textField.select();
		}
      errorFlag = true;
    }


	//below is a check for invalid email address
	var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

	if (!email.value.match(mailformat)){

		document.getElementById("emailformat_error").style.display = "block";

		if(!errorFlag){
			textField.focus();
			textField.select();
		}
		errorFlag = true;
	}
	return errorFlag;
	
}


function hideErrors()
{
	// Get an array of error elements
	let error = document.getElementsByClassName("errors");

	// Loop through each element in the error array
	for ( let i = 0; i < error.length; i++ )
	{
		// Hide the error element by setting it's display style to "none"
		error[i].style.display = "none";
	}
}

function formFieldHasInput(fieldElement)
{
	// Check if the text field has a value
	if ( fieldElement.value == null || trim(fieldElement.value) == "" ){
		return false;
	}
	
	return true;
}

function load()
{
	hideErrors();

	document.getElementById("forms").addEventListener("submit", validate, false);

	document.getElementById("forms").reset();
	document.getElementById("forms").addEventListener("reset", resetForm, false);
}

document.addEventListener("DOMContentLoaded", load);