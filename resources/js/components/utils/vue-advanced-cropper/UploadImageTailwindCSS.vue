<template>

<div>
    <div class="upload-area__cropper-wrapper">
        <cropper ref="cropper" class="upload-area__cropper rounded-lg border-transparent cute-upload border border-gray-300" :stencil-props="{
		aspectRatio: 1/1,
	}" check-orientation :src="image.src" />
		<vertical-buttons v-if="image.src">
			<square-button title="Flip Horizontal" @click="flip(true, false)">
				<img src="data:image/svg+xml,%3Csvg version='1.1' id='Layer_1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px' width='16px' height='16px' viewBox='0 0 16 16' enable-background='new 0 0 16 16' xml:space='preserve'%3E%3Cline fill='%23FFFFFF' stroke='%23FFFFFF' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' x1='8' y1='1' x2='8' y2='14.9'/%3E%3Cg%3E%3Cg%3E%3Cline fill='none' stroke='%23FFFFFF' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round' x1='11.5' y1='12.8' x2='12' y2='12.8'/%3E%3Cpolyline fill='none' stroke='%23FFFFFF' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round' points='14.2,12.8 14.7,12.8 14.7,12.3 '/%3E%3Cline fill='none' stroke='%23FFFFFF' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round' stroke-dasharray='0.8091,2.4273' x1='14.7' y1='9.9' x2='14.7' y2='4.6'/%3E%3Cpolyline fill='none' stroke='%23FFFFFF' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round' points='14.7,3.4 14.7,2.9 14.2,2.9 '/%3E%3Cline fill='none' stroke='%23FFFFFF' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round' x1='12' y1='2.9' x2='11.5' y2='2.9'/%3E%3C/g%3E%3C/g%3E%3Cpolyline fill='none' stroke='%23FFFFFF' stroke-width='1.5' stroke-linejoin='round' stroke-miterlimit='10' points='4.5,2.9 1.3,2.9 1.3,12.8 4.5,12.8 '/%3E%3C/svg%3E%0A" />
			</square-button>
			<square-button title="Flip Vertical" @click="flip(false, true)">
				<img src="data:image/svg+xml,%3Csvg version='1.1' id='Layer_1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px' width='16px' height='16px' viewBox='0 0 16 16' enable-background='new 0 0 16 16' xml:space='preserve'%3E%3Cline fill='%23FFFFFF' stroke='%23FFFFFF' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' x1='15' y1='8' x2='1' y2='8'/%3E%3Cg%3E%3Cg%3E%3Cline fill='none' stroke='%23FFFFFF' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round' x1='3.2' y1='11.5' x2='3.2' y2='12'/%3E%3Cpolyline fill='none' stroke='%23FFFFFF' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round' points='3.2,14.2 3.2,14.7 3.7,14.7 '/%3E%3Cline fill='none' stroke='%23FFFFFF' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round' stroke-dasharray='0.8091,2.4273' x1='6.1' y1='14.7' x2='11.4' y2='14.7'/%3E%3Cpolyline fill='none' stroke='%23FFFFFF' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round' points='12.6,14.7 13.1,14.7 13.1,14.2 '/%3E%3Cline fill='none' stroke='%23FFFFFF' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round' x1='13.1' y1='12' x2='13.1' y2='11.5'/%3E%3C/g%3E%3C/g%3E%3Cpolyline fill='none' stroke='%23FFFFFF' stroke-width='1.5' stroke-linejoin='round' stroke-miterlimit='10' points='13.1,4.4 13.1,1.3 3.2,1.3 3.2,4.4 '/%3E%3C/svg%3E%0A" />
			</square-button>
			<square-button title="Rotate Clockwise" @click="rotate(90)">
				<img src="data:image/svg+xml,%3Csvg version='1.1' id='Layer_1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px' width='16px' height='16px' viewBox='0 0 16 16' enable-background='new 0 0 16 16' xml:space='preserve'%3E%3Cg enable-background='new '%3E%3Cpath fill='%23FFFFFF' d='M1.5,8c0-3.7,3-6.5,6.5-6.5c1.7,0,3.3,0.7,4.5,1.8l1.1-1.1c0.1-0.1,0.4-0.1,0.6-0.1 c0.1,0.1,0.3,0.3,0.3,0.6v3.8c0,0.3-0.3,0.6-0.6,0.6h-3.8C10,6.9,9.8,6.7,9.7,6.6C9.6,6.4,9.7,6.2,9.8,6L11,4.9 C10.1,4,9.1,3.6,8,3.6c-2.4,0-4.4,2-4.4,4.4s2,4.4,4.4,4.4c1.4,0,2.5-0.6,3.4-1.7l0.1-0.1c0.1,0,0.1,0,0.3,0.1l1.1,1.1 c0.1,0.1,0.1,0.3,0,0.4c-1.1,1.4-3,2.3-4.9,2.3C4.3,14.5,1.5,11.7,1.5,8z'/%3E%3C/g%3E%3C/svg%3E%0A" />
			</square-button>
			<square-button title="Rotate Counter-Clockwise" @click="rotate(-90)">
				<img src="data:image/svg+xml,%3Csvg version='1.1' id='Layer_1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px' width='16px' height='16px' viewBox='0 0 16 16' enable-background='new 0 0 16 16' xml:space='preserve'%3E%3Cg enable-background='new '%3E%3Cpath fill='%23FFFFFF' d='M8,14.5c-2,0-3.8-0.8-5.1-2.4c-0.1-0.1-0.1-0.3,0-0.4l1.1-1.1c0,0,0.1-0.1,0.3-0.1c0.1,0,0.1,0,0.1,0.1 c1,1.3,2.1,1.8,3.5,1.8c2.4,0,4.4-2,4.4-4.4s-2-4.4-4.4-4.4c-1.1,0-2.1,0.4-3,1.1l1.1,1.1c0.1,0.3,0.3,0.4,0.1,0.7 C6.2,6.7,6.1,6.9,5.9,6.9H2c-0.3,0-0.6-0.3-0.6-0.6V2.5c0-0.3,0.1-0.4,0.3-0.6c0.1-0.1,0.4,0,0.6,0.1l1.1,1.1 c1.3-1.1,2.8-1.8,4.5-1.8c3.7,0,6.5,3,6.5,6.5S11.7,14.5,8,14.5z'/%3E%3C/g%3E%3C/svg%3E%0A" />
			</square-button>
			<square-button title="Save" @click="save()">
				<img src="data:image/svg+xml,%3Csvg version='1.1' id='Layer_1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px' width='16px' height='16px' viewBox='0 0 16 16' enable-background='new 0 0 16 16' xml:space='preserve'%3E%3Cg%3E%3Cpath fill='%23FFFFFF' d='M0.8,5.6c0-0.5,0.3-1.2,0.6-1.6l2.7-2.7c0.3-0.3,1.1-0.6,1.6-0.6h8.7c0.5,0,0.9,0.5,0.9,0.9v12.6 c0,0.5-0.5,0.9-0.9,0.9H1.6c-0.5,0-0.9-0.5-0.9-0.9V5.6H0.8z M3.2,14.1v-3.9c0-0.5,0.5-0.9,0.9-0.9h7.8c0.5,0,0.9,0.5,0.9,0.9v3.9 h1.2V1.9h-1.2v3.9c0,0.5-0.5,0.9-0.9,0.9H6.4C6,6.7,5.7,6.4,5.7,5.8V1.9C5.3,1.9,5,2,4.9,2.2L2.2,4.9C2.1,5,1.9,5.3,1.9,5.6v8.4 H3.2z M11.6,14.1v-3.7H4.4v3.6h7.2V14.1z M6.8,5.3c0,0.2,0.2,0.3,0.3,0.3h1.9c0.2,0,0.3-0.2,0.3-0.3V2.2c0-0.2-0.2-0.3-0.3-0.3H7.1 C6.9,1.9,6.8,2,6.8,2.2C6.8,2.2,6.8,5.3,6.8,5.3z'/%3E%3C/g%3E%3C/svg%3E%0A" />
			</square-button>
		</vertical-buttons>
        <div class="absolute bottom-0 right-0 p-2 flex gap-x-2">
            <button v-if="!image.src" class="flex items-center px-2 py-2 font-medium tracking-wide capitalize transition-colors duration-200 transform bg-gray-700 rounded-md hover:bg-gray-600 focus:outline-none focus:ring focus:ring-gray-300 focus:ring-opacity-80 text-yellow-500" @click="$refs.file.click()">
                <input class="hidden" ref="file" type="file" accept="image/*" @change="loadImage($event)" />
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-1" viewBox="0 0 20 20" fill="currentColor">
				  <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
				</svg>Upload image
            </button>
            <button class="flex items-center px-2 py-2 font-medium tracking-wide capitalize transition-colors duration-200 transform bg-gray-700 rounded-md hover:bg-gray-600 focus:outline-none focus:ring focus:ring-gray-300 focus:ring-opacity-80 text-yellow-500" title="Reset Image" @click="reset()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-1" viewBox="0 0 20 20" fill="currentColor">
				  <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
				</svg>Reset
            </button>
            
        </div>
        <div class="upload-area__file-type" v-if="image.type">
            Format: {{ image.type }}
        </div>
    </div>
</div>
    
</template>

<script>
import  { Cropper }  from 'vue-advanced-cropper'
import 'vue-advanced-cropper/dist/style.css';
import VerticalButtons from './components/VerticalButtons';
import SquareButton from './components/SquareButton';

// This function is used to detect the actual image type,
function getMimeType(file, fallback = null) {
	const byteArray = new Uint8Array(file).subarray(0, 4);
	let header = '';
	for (let i = 0; i < byteArray.length; i++) {
		header += byteArray[i].toString(16);
	}
	switch (header) {
		case '89504e47':
			return 'image/png';
		case '47494638':
			return 'image/gif';
		case 'ffd8ffe0':
		case 'ffd8ffe1':
		case 'ffd8ffe2':
		case 'ffd8ffe3':
		case 'ffd8ffe8':
			return 'image/jpeg';
		default:
			return fallback;
	}
}
export default {
	components: {
		Cropper,
		VerticalButtons,
		SquareButton,
	},
	data() {
		return {
			image: {
				src: null,
				type: null,
			},
		};
	},
	methods: {
		save() {
			const { canvas } = this.$refs.cropper.getResult();
			if (canvas)
				this.$emit('save', { canvas: canvas, type: this.image.type });
				this.$emit('processingImage', false);
			
		},
		reset() {
			this.image = {
				src: null,
				type: null,
			};
			this.$emit('processingImage', false);
			
		},
		flip(x, y) {
			if (this.$refs.cropper.customImageTransforms.rotate % 180 !== 0) {
				this.$refs.cropper.flip(!x, !y);
			} else {
				this.$refs.cropper.flip(x, y);
			}
		},
		rotate(angle) {
			this.$refs.cropper.rotate(angle);
		},
		loadImage(event) {
			// Reference to the DOM input element
			const { files } = event.target;
			// Ensure that you have a file before attempting to read it
			if (files && files[0]) {
				// 1. Revoke the object URL, to allow the garbage collector to destroy the uploaded before file
				if (this.image.src) {
					URL.revokeObjectURL(this.image.src);
				}
				// 2. Create the blob link to the file to optimize performance:
				const blob = URL.createObjectURL(files[0]);
				// 3. The steps below are designated to determine a file mime type to use it during the
				// getting of a cropped image from the canvas. You can replace it them by the following string,
				// but the type will be derived from the extension and it can lead to an incorrect result:
				//
				// this.image = {
				//    src: blob;
				//    type: files[0].type
				// }
				// Create a new FileReader to read this image binary data
				const reader = new FileReader();
				// Define a callback function to run, when FileReader finishes its job
				reader.onload = (e) => {
					// Note: arrow function used here, so that "this.image" refers to the image of Vue component
					this.image = {
						// Read image as base64 and set it as src:
						src: blob,
						// Determine the image type to preserve it during the extracting the image from canvas:
						type: getMimeType(e.target.result, files[0].type),
					};
				};
				// Start the reader job - read file as a data url (base64 format)
				reader.readAsArrayBuffer(files[0]);
				this.$emit('processingImage', true);
			}
		},
	},
	destroyed() {
		// Revoke the object URL, to allow the garbage collector to destroy the uploaded before file
		if (this.image.src) {
			URL.revokeObjectURL(this.image.src);
		}
	},
};
</script>

<style lang="scss">
.action-area {
		position: absolute;
		right: 20px;
		bottom: 20px;
        input {
			display: none;
		}
	}


.upload-area {
	user-select: none;
	&__cropper {
		
		min-height: 300px;
		max-height: 300px;
		width: 100%;
	}
	&__cropper-wrapper {
		position: relative;
	}
	&__file-type {
		position: absolute;
		top: 20px;
		left: 20px;
		background: #0d0d0d;
		border-radius: 5px;
		padding: 0px 10px;
		padding-bottom: 2px;
		font-size: 12px;
		color: white;
	}
}
</style>