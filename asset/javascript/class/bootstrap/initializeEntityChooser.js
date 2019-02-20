$(function() {

    if(document.location.toString().match(/\/@extension\/planck-extension-entity_editor\/entity\/main\[manage\]/)) {
        var controller = new Planck.Extension.EntityEditor.Module.Entity.Controller.EntityManager(
            $('.plk-entity-manager-container')
        );
        controller.initialize();
    }




    //Planck.Extension.EntityEditor.initialize();
});