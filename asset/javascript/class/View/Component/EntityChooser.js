Planck.Extension.EntityEditor.View.Component.EntityChooser = function(triggerElement)
{

    this.$triggerElement = $(triggerElement);

    this.$triggerElement.click(function() {
        this.showEntitySelector();
    }.bind(this))
};

Planck.Extension.EntityEditor.View.Component.EntityChooser.prototype.showEntitySelector = function()
{
   var overlay = new Planck.Extension.ViewComponent.View.Component.Overlay();
   overlay.show('hello world');
};


Planck.Extension.EntityEditor.View.Component.EntityChooser.prototype.getLabel = function()
{
    return this.$triggerElement.parents('.plk-field-container').find('label');
};
