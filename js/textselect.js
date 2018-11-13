(function ($, ts) {

  var fieldIds = ['source'];
  var customPlaceholder = 'com-joineryhq-textselect-custom';
  var customPlaceholderLabel = ts('Custom value');
  var customValues = {}
  
  var handleTextKeyup = function handleTextKeyup(e){
    id = this.id;
    customValues[id] = this.value;
  }
  
  var handleSelectChange = function handleSelectChange(e){
    var id = e.data.id;
    
    jqEl = CRM.$('input#' + id);
    
    if (this.value == customPlaceholder){
      jqEl.val(customValues[id]);
      jqEl.show();
    }
    else {
      jqEl.hide();
      jqEl.val(this.value);
    }
  }
  
  for (i in fieldIds) {
    var id = fieldIds[i];
    var jqEl = CRM.$('input#' + id)
    jqEl
      .hide()
      .before('\
        <select class="crm-form-select crm-select2" id="com-joineryhq-textselect-' + id + '">\n\
          <option></option>\n\
        </select>\n\
      ');
    
    CRM.$.each(CRM.vars['com.joineryhq.textselect'].options[id], function(key, value) {
      CRM.$('select#com-joineryhq-textselect-' + id)
        .append($("<option></option>")
        .attr("value", value)
        .text(value));
      if (value == jqEl.val()) {
        CRM.$('select#com-joineryhq-textselect-' + id).val(value);
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
    
    CRM.$('select#com-joineryhq-textselect-' + id).change({'id': id}, handleSelectChange);
    jqEl.keyup(handleTextKeyup);
  }
  
})(CRM.$, CRM.ts('com.joineryhq.textselect'));
