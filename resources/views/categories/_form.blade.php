<div class="alert alert-success" role="alert">
  <h4 class="alert-heading">Whatch out!</h4>
  <p>I would like to inform you, dear, that this is a control panel for the site that I created, and also this warning is for developers only because it is temporary because the site is under development and working. Therefore, you may encounter some errors and unavailable pages.</p>
  <p>Don't worry, the site is under development and when I'm done I will upload it again and this alert hasn't appeared yet.</p>
  <hr>
  <p class="mb-0">A glimpse of this site that I created. I advise you to visit the link : <e> https://github.com/Mohammed-Habboub</e>
    <span style="color: red;" > ( wish you the best. )</span></p>
</div>
<div class="form-group">
    <x-form.input id="name" name="name" label="Category Name" :value="$category->name"/>
</div>

<div class="form-group">
    <x-form.input id="slug" name="slug" label="Category slug" :value="$category->slug"/>
</div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="text" name="description" class="form-control @error('description') is-invalid @enderror">{{old('description',$category->description)}}</textarea>
            @error('descripton')
            <p class="text-danger">{{$message}}</p>
            @enderror
        </div>

        <div class="form-group">
            <x-form.select id="parent_id" name="parent_id" label="Parent" :options="$parents->pluck('name', 'id')" :selected="$category->parent_id" />
        </div>

        <div class="form-group">
            <label for="art_file">Art File</label>
            <input type="file" id="art_file" name="art_file" class="form-control @error('art_file') is-invalid @enderror">  
            @error('art_file')
            <p class="text-danger">{{$message}}</p>
            @enderror      
        </div>

        <div class="form-group">
            <button class="btn btn-primary">Save</button>
        </div>
