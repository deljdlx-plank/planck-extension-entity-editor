Planck.Extension.EntityEditor.View.Component.EntityChooser = function(triggerElement)
{

    this.$triggerElement = $(triggerElement);

    this.$triggerElement.click(function() {
        this.showEntitySelector();
    }.bind(this));


    this.$inputValue = $('<input name="'+this.$triggerElement.attr('name')+'" value="'+this.$triggerElement.val()+'" type="hiddeen"/>');
    this.$triggerElement.parent().append(this.$inputValue);



    this.entityType = this.$triggerElement.attr('data-entity-type');

};

Planck.Extension.EntityEditor.View.Component.EntityChooser.prototype.showEntitySelector = function()
{

    var componentName = 'Planck\\Extension\\EntityEditor\\View\\Component\\EntityList';

    var componentLoader = new Planck.Extension.ViewComponent.RemoteComponentLoader(
        componentName
    );

    componentLoader.addMethodCall('loadRepositoryByEntityName', [
        this.entityType
        //'Planck\\Extension\\Content\\Model\\Repository\\Article'
    ]);

    componentLoader.load(function(descriptor) {
        var overlay = new Planck.Extension.ViewComponent.View.Component.Overlay();
        overlay.render(document.body);
        overlay.show(descriptor.getHTML());

        var list = new Planck.Extension.EntityEditor.View.Component.EntityList(
            overlay.getElement().find('.plk-entity-list-container')
        );

        list.on('itemClick', function(descriptor) {

            this.$inputValue.val(descriptor.entity.id);

        }.bind(this));
        list.load();

    }.bind(this));



};


Planck.Extension.EntityEditor.View.Component.EntityChooser.prototype.getLabel = function()
{
    return this.$triggerElement.parents('.plk-field-container').find('label');
};
