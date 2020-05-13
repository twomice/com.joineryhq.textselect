(function ($, ts) {
  //CRM.vars['com.joineryhq.textselect']['allFieldOptions'] is now an array of [field_id => option_group_id]
  //Here we just break off the field ids to loop over
  var fieldIds = $.map(CRM.vars['com.joineryhq.textselect']['allFieldOptions'], function(element,index) {return index});
  console.log('fieldIds', fieldIds);
  var customPlaceholder = 'com-joineryhq-textselect-custom';
  var customPlaceholderLabel = ts('Custom value');
  var customValues = {}

  var handleTextKeyup = function handleTextKeyup(e){
    id = this.id;
    customValues[id] = this.value;
  }

  var handleSelectChange = function handleSelectChange(e){
    var jqEl = e.data.jqEl;

    if (this.value == customPlaceholder){
      jqEl.val(customValues[id]);
      jqEl.show();
    }
    else {
      jqEl.hide();
      jqEl.val(this.value);
    }
  }

  for (var i = 0; i < fieldIds.length; i++) {
    //Continue to support contribution source
    if (fieldIds[i] == 'contribution_source') {
      var id = 'source';
    }
    //Support custom fields
    else {
      var id = 'custom_' + fieldIds[i];
    }
    var jqEl = CRM.$('input#' + id);
    //If jqEl doesn't find anything, look harder
    if (jqEl.length == 0) {
      jqEl = CRM.$('input[id^="' + id + '_"]');
    }
    //If jqEl still doesn't find anything, give up.
    if (jqEl.length == 0) {
      console.log('could not find id', id)
      continue;
    }
    //Bugfix for contribution source field duplicated. Only do this if we haven't already for the element we found
    if ($('#com-joineryhq-textselect-' + id).length == 0) {
      jqEl
        .hide()
        .before('\
          <select class="crm-form-select crm-select2" id="com-joineryhq-textselect-' + id + '">\n\
            <option></option>\n\
          </select>\n\
        ');

        //Once we have the option values... we can continue with processing fields with values
        CRM.$.each(CRM.vars['com.joineryhq.textselect']['allFieldOptions'][fieldIds[i]], function(key, value) {
          CRM.$('select#com-joineryhq-textselect-' + id)
            .append($("<option></option>")
            .attr("value", value.label)
            .text(value.label));
          if (value.label == jqEl.val()) {
            CRM.$('select#com-joineryhq-textselect-' + id).val(value.label);
          }
        });
        CRM.$('select#com-joineryhq-textselect-' + id)
          .append($("<option></option>")
          .attr("value", customPlaceholder)
          .text('(' + customPlaceholderLabel + ')'));
        if (jqEl.val() && !CRM.$('select#com-joineryhq-textselect-' + id).val()) {
          CRM.$('select#com-joineryhq-textselect-' + id).val(customPlaceholder);
          customValues[id] = jqEl.val();
          jqEl.show();
        }
        CRM.$('select#com-joineryhq-textselect-' + id).change({'jqEl': jqEl}, handleSelectChange);
        jqEl.keyup(handleTextKeyup);
      }
    }

})(CRM.$, CRM.ts('com.joineryhq.textselect'));
