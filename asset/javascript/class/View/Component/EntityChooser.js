Planck.Extension.EntityEditor.View.Component.EntityChooser = function(triggerElement)
{

    this.model = new Planck.Model();


    this.$triggerElement = $(triggerElement);

    this.$triggerElement.click(function() {
        this.showEntitySelector();
    }.bind(this));


    this.$inputValue = $('<input name="'+this.$triggerElement.attr('name')+'" value="'+this.$triggerElement.val()+'" type="hidden"/>');
    this.$triggerElement.parent().append(this.$inputValue);

    this.$labelElement = $('<input readonly="readonly"/>');
    this.$triggerElement.parent().append(this.$labelElement);


    this.entityType = this.$triggerElement.attr('data-entity-type');

    this.loadPreview(this.$inputValue.val());

};


Planck.Extension.EntityEditor.View.Component.EntityChooser.prototype.loadPreview = function(value)
{
    if(!value) {
        return false;
    }


    var url = '?/@extension/planck-extension-entity_editor/entity/api[get]';
    var data = {
        entity: this.entityType,
        id: value
    };
    Planck.ajax({
        url: url,
        method: 'get',
        data: data,
        success: function(response) {

            var entity = this.model.getEntityByDescriptor(response);

            this.$labelElement.val(
               entity.getLabel()
            );

        }.bind(this)
    });




};



Planck.Extension.EntityEditor.View.Component.EntityChooser.prototype.showEntitySelector = function()
{

    var componentName = 'Planck\\Extension\\EntityEditor\\View\\Component\\EntityList';

    var componentLoader = new Planck.Extension.ViewComponent.RemoteComponentLoader(
        componentName
    );

    componentLoader.addMethodCall('loadRepositoryByEntityName', [
        this.entityType
    ]);

    componentLoader.load(function(descriptor) {
        var overlay = new Planck.Extension.ViewComponent.View.Component.Overlay();
        overlay.render(document.body);
        overlay.show(descriptor.getHTML());

        var list = new Planck.Extension.EntityEditor.View.Component.EntityList(
            overlay.getElement().find('.plk-entity-list-container')
        );

        list.on('itemClick', function(descriptor) {


            this.$inputValue.val(descriptor.entity.getId());
            this.$labelElement.val(descriptor.entity.getLabel());


        }.bind(this));
        list.load();

    }.bind(this));



};


Planck.Extension.EntityEditor.View.Component.EntityChooser.prototype.getLabel = function()
{
    return this.$triggerElement.parents('.plk-field-container').find('label');
};
