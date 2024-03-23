(function ($, ts) {

  // On-page storage for custom values, so we can revert without loosing data.
  var customValues = {};
  // Option value for textSelect's "custom value" option.
  var customPlaceholderValue = 'com-joineryhq-textselect-custom';
  // Human label for textSelect's "custom value" option.
  var customPlaceholderLabel = ts('Custom value');

  var a = {
    'contribution_source': [
      'form.CRM_Contribute_Form_Contribution #source',
      'form.CRM_Profile_Form_Edit #contribution_source',
      'form.crm-search-form #contribution_source'
    ],
    'contact_source': [
      '#contact_source'
    ],
    'participant_source': [
      'form.CRM_Event_Form_Participant #source',
      'form.CRM_Profile_Form_Edit #participant_source',
      'form.crm-search-form #participant_source'
    ],
    'member_source': [
      'form.CRM_Member_Form_Membership #source',
      'form.CRM_Profile_Form_Edit #member_source',
      'form.crm-search-form #member_source'
    ],
  };

  var storeCustomValue = function storeCustomValue (key, value) {
    customValues[key] = value;
  };

  var getStoredCustomValue = function getStoredCustomValue(key) {
    return customValues[key];
  };

  /**
   * Keyup event handler for native text field (when it's displayed, we want to
   * respond in certain ways to user input).
   */
  var handleNativeTextKeyup = function handleNativeTextKeyup(e){
    nativeElementId = this.id;
    storeCustomValue(nativeElementId, this.value);
  };

  /**
   * On-Change handler for textSelect. Modify value of, and/or show/hide, native
   * text field.
   */
  var handleTextSelectChange = function handleTextSelectChange(e){
    var nativeElementJq = e.data.nativeElementJq;

    // We've just changed the selection in textSelect. Respond accordingly.
    if (this.value == customPlaceholderValue){
      // If we've selected "custom value", then:
      // Restore any previous custom value to the native text field.
      var customValue = getStoredCustomValue(nativeElementJq.attr('id'));
      nativeElementJq.val(customValue);
      // Display the native text field.
      nativeElementJq.show();
    }
    else {
      // Otherwise, we're using one of our pre-set options.
      // Hide the native text field.
      nativeElementJq.hide();
      // Set the native text field to our value.
      nativeElementJq.val(this.value);
    }
  };

  var initializeTextSelectElement = function initializeTextSelectElement(fieldKey, nativeElementJq) {
    var textSelectId = 'com-joineryhq-textselect-' + nativeElementJq.attr('id');
    if ($('#' + textSelectId).length) {
      // Our textSelect already extists, so nativeElementJq is already initialized. Just return;
      return;
    }

    nativeElementJq
      .hide()
      // jshint multistr: true
      .before('\
        <select class="crm-form-select crm-select2" id="' + textSelectId + '">\n\
          <option></option>\n\
        </select>\n\
      ');
    var textSelectJq = $('#' + textSelectId);

    // Add all options to our textSelect
    for(var i in CRM.vars.textselect.allFieldOptions[fieldKey]) {
      var option = CRM.vars.textselect.allFieldOptions[fieldKey][i];
      textSelectJq
        .append($("<option></option>")
        .attr("value", option.label)
        .text(option.label));
      // Select this value in the textSelect, if it's the same as the native text value.
      if (option.label == nativeElementJq.val()) {
        textSelectJq.val(option.label);
      }
    };

    // Append a "custom value" option to the textSelect.
    textSelectJq
      .append($("<option></option>")
      .attr("value", customPlaceholderValue)
      .text('(' + customPlaceholderLabel + ')'));

    // If the native text has a value, AND it is not already selected in textSelect,
    // then it must not exist in textSelect. Therefore, set textSelect to "custom
    // value", and display the native text. Also store the native text value
    // in our "customValues" array for later reference.
    if (nativeElementJq.val() && !textSelectJq.val()) {
      textSelectJq.val(customPlaceholderValue);
      nativeElementJq.show();
      storeCustomValue(nativeElementJq.attr('id'), nativeElementJq.val());
    }

    // Set the change handler for textSelect.
    textSelectJq.change({'nativeElementJq': nativeElementJq}, handleTextSelectChange);
    // Set the keyup handler for native text.
    nativeElementJq.keyup(handleNativeTextKeyup);
  };

  for (var fieldKey in CRM.vars.textselect.allFieldOptions) {
    var selectors = CRM.vars.textselect.supportedFieldDefinitions[fieldKey].selectors;
    for (var s in selectors) {
      selector = selectors[s];
      jqEl = $(selector);
      if (jqEl.length) {
        initializeTextSelectElement(fieldKey, jqEl);
      }
    }
  }
})(CRM.$, CRM.ts('com.joineryhq.textselect'));
