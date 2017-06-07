/**
 * Created by dmetthey.stage on 25/04/2017.
 */
/**
 * Created by dmetthey.stage on 25/04/2017.
 */



function collectionFormInit($id, $sujet) {

    var $collectionHolder;

//setup an "add" link
    var $addLink = $('<div><a href="#" class="add_link btn btn-primary"><i class="fa fa-plus-circle"></i> Ajouter ' + $sujet + '</a></div>');


    //Get the div that holds the collection of users
    $collectionHolder = $('div#' + $id);

    //add a delete link to all of the existing form div
    $collectionHolder.find('div.form_line>.row').each(function () {
        addFormDeleteLink($(this));
    });
    if(isAdmin){
        //add the "add" link
        $collectionHolder.append($addLink);
    }


    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addLink.on('click', function (e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new tag form (see next code block)
        addForm($collectionHolder, $addLink);
    });

}
function addForm($collectionHolder, $addLink) {
    //Get the data prototype
    var prototype = $collectionHolder.data('prototype');

    //Get thenew index
    var index = $collectionHolder.data('index');

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    var newForm = prototype.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);





    var $newFormLi = $('<div></div>').append(newForm);
    $addLink.before($newFormLi);

    addFormDeleteLink($newFormLi.find('.row'));




}
function addFormDeleteLink($formDiv) {
    var $removeFormA = $('<a href=# class="equipe_form_delete btn btn-danger"><i class="fa fa-minus-circle"></i> Supprimer</a>');

    $formDiv.append($removeFormA);

    $removeFormA.on('click', function (e) {
        //prevent the link from creating a # on the URl
        e.preventDefault();

        //remove the User from the form
        $formDiv.remove();
    })
}
