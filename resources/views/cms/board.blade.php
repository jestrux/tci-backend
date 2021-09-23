@extends('admin.layouts.index')

@section('content')
	<style>
		h2 span{display: none}
		.board-member-card{
			min-height: 100%;
		}
		.edit-buttons{
			transition: opacity 0.25s ease-out;
		}
		.board-member-card:not(:hover) .edit-buttons{
			pointer-events: none;
			opacity: 0;
		}

		.board-member{
			padding: 2em 1em;
			text-align: center;
		}
		.board-member .image{
			width: 240px;
			height: 240px;
			margin: auto;
			margin-bottom: -20px;
			margin-bottom: -32px;
			border-radius: 50%;
			overflow: hidden;
			background: #fff;
			border: 12px solid #e8e8e8;
		}
		.board-member .image img{
			width: 100%;
			height: 100%;
			object-fit: cover;
			object-position: top;
		}
		.board-member .profile-link{
			border-radius: 50px;
			background: #e6faf9;
			padding: 0.6em 1.2em;
			display: inline-block;
			margin-bottom: 0.9em;
			letter-spacing: 0.03em;
			box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.12);
		}
		.board-member .profile-link:before{
			content: '';
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			border-radius: inherit;
			box-shadow: 0 1px 6px rgba(0, 0, 0, 0.12);
			will-change: opacity;
			transition: opacity 0.15s ease-out;
		}
		.board-member .profile-link:not(:hover):before{
			opacity: 0;
		}
		.board-member h5{
			font-size: 1.4em;
			margin-bottom: 0.4em;
			letter-spacing: 0.01em;
			color: #333;
		}
		.board-member strong{
			font-size: 1.05em;
			color: #7a7a7a;
			letter-spacing: 0;
			font-weight: 500;
		}
		.board-member small{
			display: block;
			font-size: 1.1em;
			line-height: 1.4em;
			margin-top: 0.5em;
			letter-spacing: 0.015em;
		}
	</style>

	<button class="rounded-btn border" type="button"
		onclick="newBoardMember()"
	>
		Add New Board Member
	</button>

	<div class="flex flex-wrap">
		 @foreach ($board_members as $member)
			<div class="w-1/3 px-2 py-4">
				<div class="group board-member-card overflow-hidden relative bg-white shadow rounded">
					<div class="board-member">
						<div>
							<div class="image position-relative">
								<img class="position-absolute pin-all" 
								src="{{$member->image()}}" alt="">
							</div>
							<div>
								<a target="_blank" href="{{$member->profile_link}}" class="profile-link">
									view profile
								</a>
								<h5>{{$member->name}}</h5>
								<strong>{{$member->organisation}}</strong>
								
								@if($member->position != null)
									<small>( {{$member->position}} )</small>
								@endif
							</div>
						</div>
					</div>
					<div class="edit-buttons">
						<div class="opacity-75 absolute inset-0 bg-blue-700"></div>
						<div class="absolute inset-0 flex items-center justify-center">
							<button class="rounded-btn border border-2 bg-orange-300 border-orange-500 text-orange-700 mr-4 w-32"
								onclick="editBoardMember({{$member->id}})">
								Edit
							</button>
							<button class="rounded-btn border border-2 bg-red-500 border-red-500 text-red-100 w-32"
								onclick="deleteBoardMember({{$member->id}})">
								Delete
							</button>
						</div>
					</div>
				</div>
			</div>
		@endforeach
	</div>

	@verbatim
		<div id="editBoardMember" class="modal" 
			x-data="{member: {}, uploadingImage: false, savingBoardMember: false}"
			@board-member-set.window="member = $event.detail; uploadingImage = false;"
			@board-member-saved.window="savingBoardMember = false;">
			<div class="modal-content" style="width: 500px" x-show="member != null">
				<div class="modal-title">
					<h3 class="title" x-text="member.id ? 'Edit Board Member' : 'Add Board Member'" />
				</div>
				<form action="save_board_member.php" method="POST"
					@submit="savingBoardMember = true; saveBoardMember($event, member)">
					<input type="hidden" name="id" x-model="member.id">
					<div class="modal-body overflow-y-auto" style="padding-top: 10px; padding-bottom: 17px; max-height: 480px;">
						<div class="input-group">
							<label>Image</label>
						</div>
						<span class="hidden">
							<input type="file" id="boardMemberImage"
								accept="image/x-png,image/jpeg,image/jpg,image/webp,.jpeg,.jpg,.png,.webp"
								@change="if($event.target.files.length){uploadingImage = true; uploadImage($event)}" />
							<input type="text" :value="member.imageFile" name="image" />
						</span>
						
						<label for="boardMemberImage" class="block mb-5 w-48 relative cursor-pointer rounded-full bg-gray-300">
							<img class="object-cover h-48 w-full border-grey border-8 rounded-full"
								:src="member.image" alt=""
							/>
							<span x-show="!uploadingImage" class="z-10 absolute inset-0 text-center flex items-center justify-center h-48 border-4 border-dashed border-gray-400 bg-gray-100 text-gray-500 text-xl uppercase tracking-wide rounded-full"
								:class="{'opacity-0 hover:opacity-75': member.image && member.image.length}"
								x-text="!member.image || !member.image.length ? 'Click to add image' : 'Click to change image'"
							></span>
							<span x-show="uploadingImage" class="z-10 absolute inset-0 text-center flex items-center justify-center h-48 border-4 border-dashed border-gray-400 bg-gray-100 text-gray-500 text-xl uppercase tracking-wide rounded-full">
								Uploading image...
							</span>
						</label>
						
						<div class="input-group">
							<label for="memberText">Name</label>
							<input required type="text" id="memberText" name="name" x-model="member.name">
						</div>

						<div class="input-group">
							<label for="memberOrganisation">Organisation</label>
							<input required type="text" id="memberOrganisation" name="organisation" x-model="member.organisation">
						</div>
						
						<div class="input-group">
							<label for="memberPosition">Board Position <span class="text-gray-500">(Optional)</span></label>
							<input type="text" id="memberPosition" name="position" x-model="member.position">
						</div>

						<div class="input-group">
							<label for="memberEmail">Email <span class="text-gray-500">(Optional)</span></label>
							<input type="text" id="memberEmail" name="email" x-model="member.email">
						</div>
						
						<div class="input-group">
							<label for="memberProfileLink">Profile Link</label>
							<input required type="text" id="memberProfileLink" name="profile_link" x-model="member.profile_link">
						</div>
					</div>
					<div class="modal-buttons">
						<button class="p-2 text-sm" 
							:class="{'pointer-events-none opacity-50' : savingBoardMember || uploadingImage}"
							type="reset" onclick="closeModal('editBoardMember')">
							CANCEL
						</button>
						<button class="text-sm bg-blue-800 text-white py-2 px-4 rounded" 
							:class="{'pointer-events-none opacity-50' : savingBoardMember || uploadingImage}"
							type="submit" x-text="savingBoardMember ? 'SAVING member...' : 'SAVE CHANGES'">
							SAVE CHANGES
						</button>
					</div>
				</form>
			</div>
		</div>

		<div id="deleteBoardMember" class="modal" 
			x-data="{member: {}, deletingMember: false}"
			@board-member-set.window="member = $event.detail; uploadingImage = false;"
			@board-member-deleted.window="deletingMember = false;">
			<div class="modal-content" style="width: 400px">		
				<div class="modal-body overflow-y-auto" style="padding-top: 10px; padding-bottom: 17px; max-height: 480px;">
					<p class="pt-3 px-4 text-xl text-center">
						Are you sure you want to remove <strong x-text="member.name" /></strong>
						from board members?
					</p>
				</div>
				<div class="modal-buttons">
					<button class="p-2 font-bold text-sm tracking-wider"
						:class="{'pointer-events-none opacity-50' : deletingMember}"
						onclick="closeModal('deleteBoardMember')">
						No, Cancel
					</button>
					<button class="bg-red-100 border-red-200 font-semibold px-4 py-2 rounded text-red-500 text-red-600 text-sm tracking-wider" 
						:class="{'pointer-events-none opacity-50' : deletingMember}"
						x-text="deletingMember ? 'Deleting...' : 'Yes, Remove'"
						@click="deletingMember = true; deleteBoardMember(null, true)">
						Yes, Remove
					</button>
				</div>
			</div>
		</div>
	@endverbatim
@endsection

@php
	$json_board_members = json_encode(array_map(function($member){
		$member->full_image = $member->image("../");
		return $member;
	}, $board_members->all()));
@endphp

@section('js')
<script>
	var boardMembers = {!! $json_board_members !!};
	var selectedMember = {};
	var editBoardMemberContent = document.querySelector("#editBoardMember .modal-body");
	var editBoardMemberImage = document.querySelector("#editBoardMember img");
	function editBoardMember(id){
		selectedMember = boardMembers.find((boardMember) => boardMember.id == id);
		selectedMember.image = selectedMember.full_image;
		selectedMember.imageFile = selectedMember.image;
		setSelectedMember(selectedMember);
		openModal("editBoardMember");
		editBoardMemberContent.scrollTo(0,0);
	}
	
	function deleteBoardMember(id, submit){
		if(!submit){
			selectedMember = boardMembers.find((boardMember) => boardMember.id == id);
			setSelectedMember(selectedMember);
			openModal("deleteBoardMember");
		}
		else{
			post("{{route('delete_board_member')}}", JSON.stringify({id: selectedMember.id}))
				.then((res) => {
					const event = new CustomEvent("board-member-deleted");
					window.dispatchEvent(event);
					closeModal('deleteBoardMember');
					window.location.reload();
				})
				.catch((error) => {
					console.log("slide deletion error: ", error);
					const event = new CustomEvent("board-member-deleted");
					window.dispatchEvent(event);
				});
		}
	}
	
	function newBoardMember(){
		setSelectedMember({});
		openModal("editBoardMember");
		editBoardMemberContent.scrollTo(0,0);
	}

	function setSelectedMember(member){
		editBoardMemberImage.src = "";
		const event = new CustomEvent("board-member-set", {detail: member});
		window.dispatchEvent(event);
	}

	function uploadImage(event){
		uploadFile(event.target.files[0], "board")
		.then((res) => {
			selectedMember.image = "{{asset('assets/uploads')}}/" + res;
			selectedMember.imageFile = res;
			setSelectedMember(selectedMember);
		})
		.catch((error) => console.log("Upload error: ", error));
	}
	function saveBoardMember(e, member){
		e.preventDefault();
		var {id, imageFile, name, email, organisation, position, profile_link} = member;
		var memberData = JSON.stringify({
			id, name, email, organisation, position, profile_link, image: imageFile
		});

		post("{{route('save_board_member')}}", memberData)
			.then((res) => {
				const event = new CustomEvent("board-member");
				window.dispatchEvent(event);
				closeModal('editBoardMember');
				window.location.reload();
			})
			.catch((error) => {
				console.log("slide save error: ", error);
				const event = new CustomEvent("board-member");
				window.dispatchEvent(event);
			});
	}
</script>
@endsection