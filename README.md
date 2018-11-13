# TextSelect

Converts some text fields to select fields, powered by native Option Groups; currently only supports Contribution Source field.

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
* After configuring, edit or create a contribution, and observe that the Source field is now a select field, with the options from the Option Group you've configured.
* Also notice that the select field has an additional "custom value" option, which will allow you to enter freeform text if desired.
