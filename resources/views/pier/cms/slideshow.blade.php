@extends('layouts.admin')

@section('content')

<style>
    h2 span{display: none}
    .slide-card{
        min-height: 100%;
    }
    .edit-buttons{
        transition: opacity 0.25s ease-out;
    }
    .slide-card:not(:hover) .edit-buttons{
        slideer-events: none;
        opacity: 0;
    }

    .action-label{
        padding: 0.5rem 1rem;
        padding-top: 0;
        border: 1px solid #ddd;
        border-radius: 5px;
        width: auto;
        cursor: pointer;
    }

    .action-label.active{
        border-color: #2c5282;
    }

    .action-label:before{
        content: "";
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: 2px solid #ddd;
    }

    .action-label.active:before{
        display: none;
    }

    .action-label svg{
        display: inline-block;
        width: 22px;
        height: 22px;
        margin-top: 0.5rem;
    }
    
    .action-label:not(.active) svg{
        display: none;
    }

    .action-label span:last-child{
        display: block;
        width: 100%;
        margin-top: 0.1rem;
    }
    
    .action-label input{
        display: none !important
    }

    #fileUploader{
        border-radius: 3px;
        border-color: #e4e4e4;
    }
    
    #fileUploader > div,
    #fileUploader > label{
        border-color: ;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        min-width: 0;
        position: relative;
    }

    #fileUploader > label{
        width: auto !important;
        font-size: 0.75rem;
        display: flex;
        height: 100%;
        cursor: pointer;
        font-weight: bold;
        letter-spacing: 0.03rem;
        color: #2c5282;
    }

    #fileUploader > div > span,
    #fileUploader > label > span{
        min-width: 0;
        width: 100%;
        text-overflow: ellipsis;
    }
</style>


<button class="rounded-btn border" type="button"
    onclick="newSlide()"
>
    Add New Slide
</button>
<div class="flex flex-wrap">
    @foreach ($slides as $item)
        @php
            $targetBlank = $item->targetBlank();
            $onClick = $item->onClick();
            $image = $item->image();
            $text = trim($item->text);
        @endphp    
		<div class="w-1/2 px-2 py-4">
			<div class="group slide-card overflow-hidden relative bg-white shadow rounded">
				<div class="bg-gray-100">
					<img class="block h-56 w-full object-cover" src="{{$image}}" alt="">
				</div>
				<div class="px-4 py-5">
					<h2 class="font-semibold tracking-wide text-lg">{!!$text!!}</h2>
					<a href="$item->link" target="$targetBlank"
						class="rounded-btn border" onclick="{{$onClick}}">
						{{$item->link_text}}
					</a>
				</div>
				<div class="edit-buttons">
					<div class="opacity-75 absolute inset-0 bg-blue-700"></div>
					<div class="absolute inset-0 flex items-center justify-center">
						<button class="rounded-btn border border-2 bg-orange-300 border-orange-500 text-orange-700 mr-4 w-32"
							onclick="editSlide({{$item->id}})">
							Edit
						</button>
						<button class="rounded-btn border border-2 bg-red-500 border-red-500 text-red-100 w-32"
							onclick="deleteSlide({{$item->id}})">
							Delete
						</button>
					</div>
				</div>
			</div>
		</div>
    @endforeach
</div>

@verbatim
    <div id="editSlide" class="modal" 
        x-data="{slide: {}, uploadingImage: false, uploadingFile: false, savingSlide: false}"
        x-init="$watch('slide.action', () => slide.link = '')"
        @slide-set.window="slide = $event.detail; uploadingImage = false; uploadingFile = false"
        @slide-saved.window="savingSlide = false;">
        <div class="modal-content" style="width: 500px" x-show="slide != null">
            <div class="modal-title">
                <h3 class="title" x-text="slide.id ? 'Edit Slide' : 'Add Slide'" />
            </div>
            <form action="save_slide.php" method="POST" id="newslideForm"
                @submit="savingSlide = true; saveSlide($event, slide)">
                <input type="hidden" name="id" x-model="slide.id">
                <div class="modal-body overflow-y-auto" style="padding-top: 10px; padding-bottom: 17px; max-height: 480px;">
                    <div class="input-group">
                        <label>Slide Image</label>
                        <span class="hidden">
                            <input type="file" id="slideImage" 
                                accept="image/x-png,image/jpeg,image/jpg,image/webp,.jpeg,.jpg,.png,.webp"
                                @change="if($event.target.files.length){uploadingImage = true; uploadImage($event)}" />
                            <input type="text" :value="slide.imageFile" name="image" />
                        </span>
                        
                        <label for="slideImage" class="relative cursor-pointer bg-gray-300">
                            <img class="object-cover h-48 w-full"
                                :src="slide.image" alt=""
                            />
                            <span x-show="!uploadingImage" class="z-10 absolute inset-0 flex items-center justify-center h-48 border-4 border-dashed border-gray-400 bg-gray-100 text-gray-500 text-xl uppercase tracking-wider"
                                :class="{'opacity-0 hover:opacity-75': slide.image && slide.image.length}"
                                x-text="!slide.image || !slide.image.length ? 'Click to add image' : 'Click to change image'"
                            ></span>
                            <span x-show="uploadingImage" class="z-10 absolute inset-0 flex items-center justify-center h-48 border-4 border-dashed border-gray-400 bg-gray-100 text-gray-500 text-xl uppercase tracking-wider">
                                Uploading image...
                            </span>
                        </label>
                    </div>
                    
                    <div class="input-group">
                        <label for="slideText">Slide Text</label>
                        <input required type="text" id="slideText" name="text" x-model="slide.text">
                    </div>
                    
                    <div class="input-group mb-5">
                        <label>Slide Action</label>

                        <div class="flex">
                            <label for="actionInternal" class="action-label mr-3 text-center"
                                :class="{'bg-blue-100 active' : slide.action === 'website-section'}">
                                <input id="actionInternal" required type="radio" name="action" x-model="slide.action" value="website-section" />

                                <svg class="text-blue-800" fill="currentColor" width="24" height="24" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>

                                <span>Site Section</span>
                            </label>
                            
                            <label for="actionExternal" class="action-label mr-3 text-center" 
                                :class="{'bg-blue-100 active' : slide.action === 'external-link'}">
                                <input id="actionExternal" required type="radio" name="action" x-model="slide.action" value="external-link" />

                                <svg class="text-blue-800" fill="currentColor" width="24" height="24" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>

                                <span>External Link</span>
                            </label>
                            
                            <label for="actionDownload" class="action-label text-center" 
                                :class="{'bg-blue-100 active' : slide.action === 'download'}">
                                <input id="actionDownload" required type="radio" name="action" x-model="slide.action" value="download" />

                                <svg class="text-blue-800" fill="currentColor" width="24" height="24" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>

                                <span>Download</span>
                            </label>
                        </div>
                    </div>

                    <template x-if="slide.action === 'website-section'">
                        <div class="input-group mb-3">
                            <label for="slideLink">Website Section</label>
                            <select required name="link" id="slideLink" x-model="slide.link">
                                <option value="">Choose Section</option>
                                <option value="#banner">Banner</option>
                                <option value="#aboutUs">About Us</option>
                                <option value="#whatWeDo">What We Do</option>
                                <option value="#boardOfDirectors">Board</option>
                                <option value="#newsAndEvents">News & Events</option>
                                <option value="#joinUs">Become A Member</option>
                            </select>
                        </div>
                    </template>
                    
                    <template x-if="slide.action === 'external-link'">
                        <div class="input-group mb-3">
                            <label for="slideLink">External Link</label>
                            <input required type="text" id="slideLink" name="link" x-model="slide.link">
                        </div>
                    </template>
                    
                    <template x-if="slide.action === 'download'">
                        <div class="input-group mb-3">
                            <label>File</label>
                            <span class="hidden">
                                <input type="file" id="slideLink"
                                    @change="if($event.target.files.length){uploadingFile = true; uploadSlideFile($event)}" />
                                <input type="text" :value="slide.link" name="link" required />
                            </span>
                            
                            <div class="relative">
                                <div id="fileUploader" class="h-12 py-2 flex border-solid border-2">
                                    <div class="flex-1 flex pl-3 items-center">
                                        <template x-if="uploadingFile">
                                            <span class="text-blue-800">Uploading file...</span>
                                        </template>
                                        <template x-if="!uploadingFile">
                                            <span :class="{'opacity-50': !slide.link.length}"
                                                x-text="slide.link.length ? slide.link : 'No file chosen'" />
                                        </template>
                                    </div>

                                    <label for="slideLink" class="w-auto border-solid border-l flex items-center px-3 ml-3 text-xs text-blue-800 tracking-wide uppercase"
                                        :class="{'pointer-events-none opacity-50': uploadingFile}">
                                        <span x-text="slide.link.length ? 'Change' : 'Choose'" />
                                    </label>
                                </div>
                            </div>
                        </div>
                    </template>

                    <div class="input-group">
                        <label for="slideLinkText">Action Text</label>
                        <input required type="text" id="slideLinkText" name="link_text" x-model="slide.link_text">
                    </div>
                </div>
                <div class="modal-buttons">
                    <button class="p-2 text-sm" 
                        :class="{'pointer-events-none opacity-50' : savingSlide || uploadingImage || uploadingFile}"
                        type="reset" onclick="closeModal('editSlide')">
                        CANCEL
                    </button>
                    <button class="text-sm bg-blue-800 text-white py-2 px-4 rounded" 
                        :class="{'pointer-events-none opacity-50' : savingSlide || uploadingImage || uploadingFile}"
                        type="submit" x-text="savingSlide ? 'SAVING SLIDE...' : 'SAVE CHANGES'">
                        SAVE CHANGES
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="deleteSlide" class="modal" 
        x-data="{deletingSlide: false}"
        @slide-deleted.window="deletingSlide = false;">
        <div class="modal-content" style="width: 400px">		
            <div class="modal-body overflow-y-auto" style="padding-top: 10px; padding-bottom: 17px; max-height: 480px;">
                <p class="pt-3 px-4 text-2xl text-center">
                    Are you sure you want to delete slide?
                </p>
            </div>
            <div class="modal-buttons">
                <button class="p-2 font-bold text-sm tracking-wider"
                    :class="{'pointer-events-none opacity-50' : deletingSlide}"
                    onclick="closeModal('deleteSlide')">
                    No, Cancel
                </button>
                <button class="bg-red-100 border-red-200 font-semibold px-4 py-2 rounded text-red-500 text-red-600 text-sm tracking-wider" 
                    :class="{'pointer-events-none opacity-50' : deletingSlide}"
                    x-text="deletingSlide ? 'Deleting...' : 'Yes, Delete'"
                    @click="deletingSlide = true; deleteSlide(null, true)">
                    Yes, Delete
                </button>
            </div>
        </div>
    </div>
@endverbatim

@endsection

@php
    $json_slides = json_encode(array_map(function($item){
        $item->full_image = $item->image("../");
        return $item;
    }, $slides->all() ));
@endphp

@section('js')
    
<script>
	var slides = {!! $json_slides !!};
	var selectedSlide = {};
	var editSlideContent = document.querySelector("#editSlide .modal-body");
	var editSlideImage = document.querySelector("#editSlide img");
	function editSlide(id){
		selectedSlide = slides.find((slide) => slide.id == id);
		selectedSlide.image = selectedSlide.full_image;
		selectedSlide.imageFile = selectedSlide.image;
		setSelectedSlide(selectedSlide);
		openModal("editSlide");
		editSlideContent.scrollTo(0,0);
	}
	
	function deleteSlide(id, submit){
		if(!submit){
			selectedSlide = id;
			openModal("deleteSlide");
		}
		else{
			post("{{route('delete_slide')}}", JSON.stringify({id: selectedSlide}))
				.then((res) => {
					const event = new CustomEvent("slide-deleted");
					window.dispatchEvent(event);
					closeModal('deleteSlide');
					window.location.reload();
				})
				.catch((error) => {
					console.log("slide deletion error: ", error);
					const event = new CustomEvent("slide-deleted");
					window.dispatchEvent(event);
				})
		}
	}
	
	function newSlide(){
		setSelectedSlide({action: 'website-section', link: ''});
		openModal("editSlide");
		editSlideContent.scrollTo(0,0);
    }

	function setSelectedSlide(slide){
        selectedSlide = slide;
		editSlideImage.src = "";
		const event = new CustomEvent("slide-set", {detail: slide});
		window.dispatchEvent(event);
    }
    
	function uploadImage(event){
		uploadFile(event.target.files[0], "slideshow")
		.then((res) => {
			selectedSlide.image = "{{asset('assets/uploads')}}/" + res;
			selectedSlide.imageFile = res;
			setSelectedSlide(selectedSlide);
		})
		.catch((error) => console.log("Upload error: ", error))
    }
    
    function uploadSlideFile(event){
		uploadFile(event.target.files[0])
		.then((res) => {
			selectedSlide.fileName = event.target.files[0].name;
			selectedSlide.link = res;
			setSelectedSlide(selectedSlide);
		})
		.catch((error) => console.log("Upload error: ", error))
    }
    
	function saveSlide(e, slide){
		e.preventDefault();
		var {id, imageFile, text, action, link, link_text} = slide;
		var slideData = JSON.stringify({
			id, text, action, link, link_text, image: imageFile
		});
		post("{{route('save_slide')}}", slideData)
			.then((res) => {
				const event = new CustomEvent("slide-saved");
				window.dispatchEvent(event);
				closeModal('editSlide');
				window.location.reload();
			})
			.catch((error) => {
				console.log("slide save error: ", error);
				const event = new CustomEvent("slide-saved");
				window.dispatchEvent(event);
			});
	}
</script>

@endsection