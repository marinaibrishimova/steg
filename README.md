# This module retrieves image data and a numerical message, embeds the message into the 
the alpha channel of the image data, and retrieves the message back using a key that
 uses the timestamp of the initial user interaction. The alpha channel of a PNG image 
 is the transparency channel and it is usually set to 0 unless the image contains 
 transparent pixels. 
 
The alpha channel of a pixel is an integer between 0 and 127 where 127 means that 
the pixel is transparent. Therefore changes to this channel such increasing it to
an integer less than 9 do not affect the overall appearance of the image. Furthermore, 
if the alpha channel of every single pixel in an image is made to be an integer between
0 and 9 then it would be hard to identify which pixels contain the message.
  
  This module uses the CodeIgniter framework and does not require any additional image
  libraries. The most important functions, namely the one that embed and retrieve a 
  message can be found in /application/models/steg.php
  
ENSTEG Function 
1. For each pixel at location 
x == key*
Add a digit from msg array to alpha channel, move onto next digit
Save pixel
2. Add random digits to the alpha channels of other pixel as distraction

*where key = timestamp mod width/2

DESTEG Function
1. For each pixel at location 
x == key
Grab alpha value
Put value into array
Return array

DEMO at https://marinaibrishimova.net/steg/
