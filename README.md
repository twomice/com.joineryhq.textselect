# TextSelect

Converts some text fields to select fields, powered by native Option Groups; currently supports:

* Contribution Source field
* All custom fields where Input Field Type is "Text"

![Screenshot](/images/screenshot.png)

The extension is licensed under [GPL-3.0](LICENSE.txt).

## Installation (Web UI)

This extension has not yet been published for installation via the web UI.

## Installation (CLI, Zip)

Sysadmins and developers may download the `.zip` file for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
cd <extension-dir>
cv dl com.joineryhq.textselect@https://github.com/twomice/com.joineryhq.textselect/archive/master.zip
```

## Installation (CLI, Git)

Sysadmins and developers may clone the [Git](https://en.wikipedia.org/wiki/Git) repo for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
git clone https://github.com/twomice/com.joineryhq.textselect.git
cv en textselect
```

## Functionality

* After installing, navigate to Administer > Customize Data and Screens > TextSelect settings; here you can select the desired Option Group to use for options in supported fields.
* After configuring, edit or create an entity having the field you've configured.
  * If you've configured TextSelect to handle the Contribution Source field, you'll see that the Source field for a Contribution is now a select field, with the options from the Option Group you've configured.
  * If you've configured TextSelect for any other custom Text field, you'll see that field is now a select field, with the options from the Option Group you've configured.
* Also notice that the select field has an additional "custom value" option, which will allow you to enter freeform text if desired.


## Support
![screenshot](/images/joinery-logo.png)

Joinery provides services for CiviCRM including custom extension development, training, data migrations, and more. We aim to keep this extension in good working order, and will do our best to respond appropriately to issues reported on its [github issue queue](https://github.com/twomice/com.joineryhq.textselect/issues). In addition, if you require urgent or highly customized improvements to this extension, we may suggest conducting a fee-based project under our standard commercial terms.  In any case, the place to start is the [github issue queue](https://github.com/twomice/com.joineryhq.textselect/issues) -- let us hear what you need and we'll be glad to help however we can.

And, if you need help with any other aspect of CiviCRM -- from hosting to custom development to strategic consultation and more -- please contact us directly via https://joineryhq.com