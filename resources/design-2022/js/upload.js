// // Custom input file
// $(function ( document, window, index ){
// 	var inputs = document.querySelectorAll('.inputfile');
// 	Array.prototype.forEach.call( inputs, function( input ){
// 		var label	 = input.nextElementSibling,
// 			labelVal = label.innerHTML;
// 		input.addEventListener( 'change', function( e )	{
// 			var fileName = '';
// 			if( this.files && this.files.length > 1 )
// 				fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
// 			else
// 				fileName = e.target.value.split( '\\' ).pop();
//
// 			if( fileName )
// 				label.querySelector( '.upload__caption' ).innerHTML = fileName;
// 			else
// 				label.innerHTML = labelVal;
// 		});
//
// 		// Firefox bug fix
// 		input.addEventListener( 'focus', function(){ input.classList.add( 'has-focus' ); });
// 		input.addEventListener( 'blur', function(){ input.classList.remove( 'has-focus' ); });
// 	});
// }( document, window, 0 ));

					if (typeof avatar !== 'undefined' &&
						typeof filename !== 'undefined' &&
						typeof preview !== 'undefined' &&
						typeof priveiwblock !== 'undefined' &&
						typeof previewclearbtn !== 'undefined') {
						avatar.onchange = evt => {
							const [file] = avatar.files
							if (file) {
								filename.innerHTML  = file.name;
								preview.src = URL.createObjectURL(file)
								priveiwblock.classList.add("active");
							}
						}
						
						previewclearbtn.addEventListener('click', function(){
							if(avatar.value){
								try{
									avatar.value = ''; //for IE11, latest Chrome/Firefox/Opera...
								}catch(err){ }
								if(avatar.value){ //for IE5 ~ IE10
									var form = document.createElement('form'),
										parentNode = avatar.parentNode, ref = avatar.nextSibling;
									form.appendChild(avatar);
									form.reset();
									parentNode.insertBefore(avatar,ref);
								}
								filename.innerHTML  = 'Выберите аватар';
								preview.src = '';
								priveiwblock.classList.remove("active");
							}
						});
					}