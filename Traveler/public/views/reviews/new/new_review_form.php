<form class="hide" id="new-review-form" method="post" action="/reviews/add" enctype="multipart/form-data">
    <div class="form-content">
        <button type="button" id="hide-review-form-button">
            <i class="material-icons">arrow_back_ios_new</i>
        </button>
        <div class="form-header">Опишіть свої враження від співпраці з Traveler:</div>
        <textarea id="new-review-text" name="text" placeholder="Місце для відгуку" spellcheck="false"></textarea>
        <div class="new-photo-list" id="new-photo-list">
            <div class="new-photo-text">Додайте фото через "+", перетягнувши на форму або вставивши з буферу обміну</div>
            <label for="photo-list-input" class="add">
                <i class="material-icons">add_photo_alternate</i>
                <input id="photo-list-input" name="photo_list[]" type="file" accept=".jpg, .png" multiple>
            </label>

        </div>
    </div>
</form>