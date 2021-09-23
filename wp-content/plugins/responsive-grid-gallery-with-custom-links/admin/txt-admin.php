<?php
//FREE Free + Pro sync.
function abcfrggcl_txta($id, $suffix='') {

    switch ($id){
        case 0:
            $out = '';
            break;
        case 1:
            $out = __('Help', 'responsive-grid-gallery-custom-links');
            break;
        case 2:
            $out = __('Gallery Item', 'responsive-grid-gallery-custom-links');
            break;
        case 3:
            $out = __('Shortcode', 'responsive-grid-gallery-custom-links');
            break;
        case 4:
            $out = __('Uninstall', 'responsive-grid-gallery-custom-links');
            break;
        case 5:
            $out = __('Yes', 'responsive-grid-gallery-custom-links');
            break;
        case 6:
            $out = __('No', 'responsive-grid-gallery-custom-links');
            break;
        case 7:
            $out = __('Default', 'responsive-grid-gallery-custom-links');
            break;
        case 8:
            $out = __('License', 'responsive-grid-gallery-custom-links');
            break;
        case 9:
            $out = __('Options', 'responsive-grid-gallery-custom-links');
            break;
//--------------------------------
        case 10:
            $out = __('Font Size', 'responsive-grid-gallery-custom-links');
            break;
       case 11:
            $out = __('Documentation', 'responsive-grid-gallery-custom-links');
            break;
       case 12:
            $out = __('Admin', 'responsive-grid-gallery-custom-links');
            break;
       case 13:
            $out = __('Layout', 'responsive-grid-gallery-custom-links');
            break;
        case 14:
            $out = __('Width', 'responsive-grid-gallery-custom-links');
            break;
        case 15:
            $out = __('Top Margin', 'responsive-grid-gallery-custom-links');
            break;
        case 16:
            $out = __('Number of Columns', 'responsive-grid-gallery-custom-links');
            break;
        case 17:
            $out = __('Image URL', 'responsive-grid-gallery-custom-links');
            break;
        case 18:
            $out = __('Custom Inline Style', 'responsive-grid-gallery-custom-links');
            break;
        case 19:
            $out = __('Gallery Options', 'responsive-grid-gallery-custom-links');
            break;
//--------------------------------
        case 20:
            $out = __('Custom', 'responsive-grid-gallery-custom-links');
            break;
        case 21:
             $out = __('Activate Key', 'responsive-grid-gallery-custom-links');
             break;
        case 22:
             $out = __('License Key', 'responsive-grid-gallery-custom-links');
             break;
        case 23:
            $out = __('Hide', 'responsive-grid-gallery-custom-links');
            break;
       case 24:
            $out = __('Delete Field', 'responsive-grid-gallery-custom-links');
            break;
        case 25:
            $out = __('Bottom Margin', 'responsive-grid-gallery-custom-links');
            break;
        case 26:
            $out = __('Field Description (URL)', 'responsive-grid-gallery-custom-links');
            break;
        case 27:
            $out = __('Image', 'responsive-grid-gallery-custom-links');
            break;
        case 28:
            $out = __('Hyperlink', 'responsive-grid-gallery-custom-links');
            break;
        case 29:
            $out = __('Horizontal Line', 'responsive-grid-gallery-custom-links');
            break;
//--------------------------------
        case 30:
            $out = __('Sort Type', 'responsive-grid-gallery-custom-links');
            break;
        case 31:
            $out = __('Text', 'responsive-grid-gallery-custom-links');
            break;
        case 32:
            $out = __('Email', 'responsive-grid-gallery-custom-links');
            break;
        case 33:
            $out = __('', 'responsive-grid-gallery-custom-links');
            break;
        case 34:
            $out = __('Text Editor', 'responsive-grid-gallery-custom-links');
            break;
        case 35:
            $out = __('Select Field Type', 'responsive-grid-gallery-custom-links');
            break;
        case 36:
            $out = __('Hide/Delete', 'responsive-grid-gallery-custom-links');
            break;
        case 37:
            $out = __('Field HTML Tag', 'responsive-grid-gallery-custom-links');
            break;
        case 38:
            $out = __('Single Line Text', 'responsive-grid-gallery-custom-links');
            break;
        case 39:
            $out = __('Left-Right Margins', 'responsive-grid-gallery-custom-links');
             break;
        case 40:
            $out = __('Border', 'responsive-grid-gallery-custom-links');
             break;
//--------------------------------
        case 41:
            $out = __('Field Label (Link Text)', 'responsive-grid-gallery-custom-links');
             break;
        case 42:
            $out = __('Menu Items', 'responsive-grid-gallery-custom-links');
            break;
       case 43:
            $out = __('Image Style', 'responsive-grid-gallery-custom-links');
            break;
       case 44:
            $out = __('None', 'responsive-grid-gallery-custom-links');
            break;
        case 45:
            $out = __('Item Order', 'responsive-grid-gallery-custom-links');
            break;
        case 46:
            $out = __('Thickness - Color', 'responsive-grid-gallery-custom-links');
            break;
        case 47:
            $out = __('Font', 'responsive-grid-gallery-custom-links');
            break;
        case 48:
            $out = __('Field Label', 'responsive-grid-gallery-custom-links');
            break;
        case 49:
            $out = __('Field Description', 'responsive-grid-gallery-custom-links');
            break;
//--------------------------------
        case 50:
            $out = __('Field Type', 'responsive-grid-gallery-custom-links');
            break;
        case 51:
            $out = __('Custom CSS Class', 'responsive-grid-gallery-custom-links');
            break;
        case 52:
            $out = __('Field Label (URL)', 'responsive-grid-gallery-custom-links');
            break;
        case 53:
            $out = __('Image Link', 'responsive-grid-gallery-custom-links');
            break;
        case 54:
            $out = __('Gallery Template', 'responsive-grid-gallery-custom-links');
            break;
        case 55:
            $out = __('Field Order', 'responsive-grid-gallery-custom-links');
            break;
        case 56:
            $out = __('Add a Field', 'responsive-grid-gallery-custom-links');
            break;
        case 57:
            $out = __('Categories', 'responsive-grid-gallery-custom-links');
            break;
        case 58:
            $out = __('Menu Label', 'responsive-grid-gallery-custom-links');
            break;
        case 59:
            $out = __('Paragraph Text', 'responsive-grid-gallery-custom-links');
            break;
//--------------------------------
        case 60:
            $out = __('Manual', 'responsive-grid-gallery-custom-links');
            break;
        case 61:
            $out = __('Sort Text', 'responsive-grid-gallery-custom-links');
            break;
        case 62:
            $out = __('Custom Link', 'responsive-grid-gallery-custom-links');
            break;
        case 63:
            $out = __('Input Fields', 'responsive-grid-gallery-custom-links');
            break;
        case 64:
            $out = __('Visual Assistance', 'responsive-grid-gallery-custom-links');
            break;
        case 65:
            $out = __('Item Container', 'responsive-grid-gallery-custom-links');
            break;
        case 66:
            $out = __('Gallery Container', 'responsive-grid-gallery-custom-links');
            break;
        case 67:
            $out = __('Text Container', 'responsive-grid-gallery-custom-links');
            break;
        case 68:
            $out = __('Text Container Width = Image Width', 'responsive-grid-gallery-custom-links');
            break;
       case 69:
            $out = __('Center Container', 'responsive-grid-gallery-custom-links');
            break;
//--------------------------------
        case 70:
            $out = __('Menu Items Left/Right Margins', 'responsive-grid-gallery-custom-links');
            break;
        case 71:
            $out = __('Container Width', 'responsive-grid-gallery-custom-links');
            break;
        case 72:
            $out = __('Center Items', 'responsive-grid-gallery-custom-links');
            break;
        case 73:
            $out = __('Highlight', 'responsive-grid-gallery-custom-links');
            break;
        case 74:
            $out = __('Underline', 'responsive-grid-gallery-custom-links');
            break;
        case 75:
            $out = __('Links Target', 'responsive-grid-gallery-custom-links');
            break;
        case 76:
            $out = __('Current tab', 'responsive-grid-gallery-custom-links');
            break;
        case 77:
            $out = __('New tab', 'responsive-grid-gallery-custom-links');
            break;
        case 78:
            $out = __('How to add a menu to a gallery page.', 'responsive-grid-gallery-custom-links');
            break;
        case 79:
            $out = __('Gallery Template > Options > Menu.', 'responsive-grid-gallery-custom-links');
            break;
//--------------------------------
        case 80:
            $out = __('Custom Styles', 'responsive-grid-gallery-custom-links');
            break;
        case 81:
            $out = __('Optional.', 'responsive-grid-gallery-custom-links');
            break;
        case 82:
            $out = __('Select the menu from a drop-down.', 'responsive-grid-gallery-custom-links');
            break;
        case 83:
            $out = __('Gallery', 'responsive-grid-gallery-custom-links');
            break;
        case 84:
            $out = __('Link Attributes', 'responsive-grid-gallery-custom-links');
            break;
        case 85:
            $out = __('Text Fields', 'responsive-grid-gallery-custom-links');
            break;
        case 86:
            $out = __('Default Template', 'responsive-grid-gallery-custom-links');
            break;
        case 87:
            $out = __('Gallery Item Data', 'responsive-grid-gallery-custom-links');
            break;
        case 88:
            $out = __('Menu Container', 'responsive-grid-gallery-custom-links');
            break;
        case 89:
            $out = __('Bottom Margin', 'responsive-grid-gallery-custom-links');
            break;
//--------------------------------
        case 90:
            $out = __('Menu Item', 'responsive-grid-gallery-custom-links');
            break;
        case 91:
            $out = __('Font Color', 'responsive-grid-gallery-custom-links');
            break;
        case 92:
            $out = __('Active Item Decoration', 'responsive-grid-gallery-custom-links');
            break;
        case 93:
            $out = __('Uppercase', 'responsive-grid-gallery-custom-links');
            break;
        case 94:
            $out = __('Grid Gallery Page URL', 'responsive-grid-gallery-custom-links');
            break;
        case 95:
            $out = __('Menu Label - All Records', 'responsive-grid-gallery-custom-links');
            break ;
        case 96:
            $out = __('Category Slug', 'responsive-grid-gallery-custom-links');
            break;
        case 97:
            $out = __('Gray', 'responsive-grid-gallery-custom-links');
            break;
        case 98:
            $out = __('Dark Gray', 'responsive-grid-gallery-custom-links');
            break;
        case 99:
            $out = __('Black', 'responsive-grid-gallery-custom-links');
            break;
//--------------------------------
        case 100:
            $out = __('Menu', 'responsive-grid-gallery-custom-links');
            break;
        case 101:
            $out = __('Valid data entry formats for Width or Margins: 15, 15px, 15%, 15em. Blank (no entry) = default value.', 'responsive-grid-gallery-custom-links');
            break;
        case 104:
            $out = __('Default: 100%.', 'responsive-grid-gallery-custom-links');
            break;
        case 106:
            $out = __('Default: 100% of the parent container.', 'responsive-grid-gallery-custom-links');
            break;
        case 107:
            $out = __('Default: 0 (zero pixels).', 'responsive-grid-gallery-custom-links');
             break;
        case 109:
            $out = __('Blank (no entry) = default value.', 'responsive-grid-gallery-custom-links');
            break ;
//--------------------------------
        case 110:
            $out = __('Page you want to add Categories Menu to.', 'responsive-grid-gallery-custom-links');
            break ;
        case 111:
            $out = __('Optional. Menu item to show all records. Example: <strong>All</strong>', 'responsive-grid-gallery-custom-links');
            break ;
        case 112:
            $out = __('Add categoty slugs. Menu will show category names as navigation labels.', 'responsive-grid-gallery-custom-links');
            break ;
        case 113:
            $out = __('', 'responsive-grid-gallery-custom-links');
            break;
        case 114:
            $out = __('', 'responsive-grid-gallery-custom-links');
            break;
        case 115:
            $out = __('', 'responsive-grid-gallery-custom-links');
            break;
        case 116:
            $out = __('Save Changes');
            break ;
        case 117:
            $out = __('Grid Gallery', 'responsive-grid-gallery-custom-links');
            break ;
        case 118:
            $out = 'Isotope';
            break ;
        case 119:
            $out = __('Pagination', 'responsive-grid-gallery-custom-links');
            break ;
//--------------------------------
        case 120:
            $out = __('Records per Page', 'responsive-grid-gallery-custom-links');
            break;
        case 121:
            $out = __('Number of Page Links', 'responsive-grid-gallery-custom-links');
            break;
        case 122:
            $out = __('Color Schema', 'responsive-grid-gallery-custom-links');
            break;
        case 123:
            $out = __('Control Size', 'responsive-grid-gallery-custom-links');
            break;
        case 124:
            $out = __('Alignment', 'responsive-grid-gallery-custom-links');
            break;
        case 125:
            $out = __('Location', 'responsive-grid-gallery-custom-links');
            break;
        case 126:
            $out = __('Top', 'responsive-grid-gallery-custom-links');
            break;
        case 127:
            $out = __('Bottom', 'responsive-grid-gallery-custom-links');
            break;
        case 128:
            $out = __('Blue', 'responsive-grid-gallery-custom-links');
            break;
        case 129:
            $out = __('Large', 'responsive-grid-gallery-custom-links');
            break;
//--------------------------------
        case 130:
            $out = __('Medium', 'responsive-grid-gallery-custom-links');
            break;
        case 131:
            $out = __('Small', 'responsive-grid-gallery-custom-links');
            break;
        case 132:
            $out = __('Extra Small', 'responsive-grid-gallery-custom-links');
            break;
        case 133:
            $out = __('Left', 'responsive-grid-gallery-custom-links');
            break;
        case 134:
            $out = __('Middle', 'responsive-grid-gallery-custom-links');
            break;
        case 135:
            $out = __('Right', 'responsive-grid-gallery-custom-links');
            break;
        case 136:
            $out = __('Overlay', 'responsive-grid-gallery-custom-links');
            break;
        case 137:
            $out = __('Darken', 'responsive-grid-gallery-custom-links');
            break;
        case 138:
            $out = __('Lighten', 'responsive-grid-gallery-custom-links');
            break;
        case 139:
            $out = __('Decolorize', 'responsive-grid-gallery-custom-links');
            break;
//--------------------------------
        case 140:
            $out = __('Tilt', 'responsive-grid-gallery-custom-links');
            break;
        case 141:
            $out = __('Drop Shadow', 'responsive-grid-gallery-custom-links');
            break;

//--------------------------------
       case 200:
            $out = __('Email link requires two input fields: <b>Link Text</b>  and <b>Email Adress</b>. The Link Text is the visible part displayed on the page.', 'responsive-grid-gallery-custom-links');
            break;
        case 201:
            $out = __('After all images are loaded.', 'responsive-grid-gallery-custom-links');
            break;
        case 202:
            $out = __('Show a wireframe to assist with laying out content.', 'responsive-grid-gallery-custom-links');
            break;
        case 203:
            $out = __('Default: '. abcfrggcl_txta(54), 'responsive-grid-gallery-custom-links');
            break;
         case 204:
            $out = __('You can\'t delete this gallery. It\'s used by one or more gallery items.', 'responsive-grid-gallery-custom-links');
            break;
        case 205:
            $out = __('Custom hyperlink. Enter destination address (URL).', 'responsive-grid-gallery-custom-links');
            break;
        case 206:
            $out = __('How field data will show up on front-end. Select HTML tag, font size, margin etc.', 'responsive-grid-gallery-custom-links');
            break;
        case 207:
            $out = __('Default = Font used by your theme.', 'responsive-grid-gallery-custom-links');
            break;
        case 208:
            $out = __('Gallery will be sorted in ascending alphabetical order, according to the Sort Text values.', 'responsive-grid-gallery-custom-links');
            break;
        case 209:
            $out = __('The label of the form field. This is the field title the user will see when filling out the form.', 'responsive-grid-gallery-custom-links');
            break;
//--------------------------------
        case 210:
            $out = __('Hide = keep data but do not display it on the front-end.', 'responsive-grid-gallery-custom-links');
            break;
        case 211:
            $out = __('Default: DIV. Select HTML tag for field content.', 'responsive-grid-gallery-custom-links');
            break;
        case 212:
            $out = __('What type of content the field will contain: text, hyperlink, email etc.', 'responsive-grid-gallery-custom-links');
            break;
        case 213:
            $out = __('Field Style', 'responsive-grid-gallery-custom-links');
            break;
        case 214:
            $out = __('Gallery has no fields.', 'responsive-grid-gallery-custom-links');
            break;
        case 215:
            $out = __('Space between bottom of the image and top of the text section.', 'responsive-grid-gallery-custom-links');
            break;
        case 216:
            $out = __('Text to sort items by. Leave it empty for manual sort.', 'responsive-grid-gallery-custom-links');
            break;
        case 217:
            $out = __('Simply drag the items up or down and they will be saved in that order.', 'responsive-grid-gallery-custom-links');
            break;
        case 218:
            $out = __('Default: 100%. Valid data entry formats: px, %, em. Example: 15, 15px, 15%, 15em. Blank (no entry) = default value.', 'responsive-grid-gallery-custom-links');
            break;
        case 219:
            $out = __('Field Display Options', 'responsive-grid-gallery-custom-links');
            break;
//--------------------------------
        case 220:
            $out = __('The description for the form field to provide the user some direction on how the field should be filled out.', 'responsive-grid-gallery-custom-links');
            break;
        case 221:
            $out = __('Link onClick JS', 'responsive-grid-gallery-custom-links');
            break;
        case 222:
            $out = __('Field ID.&nbsp;&nbsp;Field type.', 'responsive-grid-gallery-custom-links');
            break;
        case 223:
            $out = __('The CSS class name you would like to use in order to override the default styles for this field.', 'responsive-grid-gallery-custom-links');
            break;
        case 224:
            $out = __('The CSS style you would like to use in order to override the default styles for this field.', 'responsive-grid-gallery-custom-links');
            break;
        case 225:
            $out = __('Gallery has no images.', 'responsive-grid-gallery-custom-links');
            break;
        case 226:
            $out = __('Field Labels', 'responsive-grid-gallery-custom-links');
            break;
        case 227:
             $out = __('How to publish Galleries', 'responsive-grid-gallery-custom-links');
            break;
       case 228:
            $out = __('1px image border.', 'responsive-grid-gallery-custom-links');
            break;
        case 229:
            $out = __('Swiching templates may cause loss of data.', 'responsive-grid-gallery-custom-links');
            break;
//--------------------------------
        case 230:
            $out = __('Hyperlink requires two fields: <b>Link Text</b>  and <b>URL</b>. The link text is the visible part. The URL specifies the destination address of the link.', 'responsive-grid-gallery-custom-links');
            break;
        case 231:
            $out = __('When images start loading.', 'responsive-grid-gallery-custom-links');
            break;
        case 232:
            $out = __('Add Script: Images Loaded', 'responsive-grid-gallery-custom-links');
            break;
        case 233:
            $out = __('Optional. Text container can span the width of the column or be limited to width of the image.', 'responsive-grid-gallery-custom-links');
            break;
        case 234:
            $out = __('Default: rggclImgCenter', 'responsive-grid-gallery-custom-links');
            break;
        case 235:
            $out = __('Editing has been disabled. Ucheck chekbox and update record to enable.', 'responsive-grid-gallery-custom-links');
            break;
        case 236:
            $out = __('Disable editing to prevent accidental changes.', 'responsive-grid-gallery-custom-links');
            break;
        case 237:
            $out = __('Left-Right Margins', 'responsive-grid-gallery-custom-links');
            break;
        case 238:
            $out = __('ALT Tag', 'responsive-grid-gallery-custom-links');
            break;
        case 239:
            $out = __('Select Image', 'responsive-grid-gallery-custom-links');
            break;
//--------------------------------
        case 240:
            $out = __('Animations on Hover', 'responsive-grid-gallery-custom-links');
            break;
        case 241:
            $out = __('To center gallery when container width is >100% add custom class: <b>rggclMLRAuto</b>', 'responsive-grid-gallery-custom-links');
            break;
        case 242:
            $out = __('To horizontally center content container when width is >100%.', 'responsive-grid-gallery-custom-links');
            break;
        case 243:
            $out = __(' Supported HTML tags: <strong>b, br, em, i, strong.</strong> ', 'responsive-grid-gallery-custom-links');
            break;
        case 244:
            $out = __('Select Gallery Template', 'responsive-grid-gallery-custom-links');
            break;
        case 245:
            $out = __('Field Description (Link Text)', 'responsive-grid-gallery-custom-links');
            break;
        case 246:
            $out = __('Shortcode Options', 'responsive-grid-gallery-custom-links');
            break;
        case 247:
            $out = __('Title Tag', 'responsive-grid-gallery-custom-links');
            break;
        case 248:
            $out = __('', 'responsive-grid-gallery-custom-links');
            break;
        case 249:
            $out = __('', 'responsive-grid-gallery-custom-links');
            break;
//--------------------------------
        case 250:
            $out = __('', 'responsive-grid-gallery-custom-links');
            break;
        case 251:
            $out = __('1. Create a gallery page if not already created.', 'responsive-grid-gallery-custom-links');
            break;
        case 252:
            $out = __('2. Open the gallery page for preview.', 'responsive-grid-gallery-custom-links');
            break;
        case 253:
            $out = __('3.  Copy page\'s URL from the address bar and paste it into Grid Gallery Page URL field (above).', 'responsive-grid-gallery-custom-links');
            break;
        case 254:
            $out = __('4. Open the gallery page for edit. ', 'responsive-grid-gallery-custom-links');
            break;
        case 255:
            $out = __('5. Copy menu shortcode and paste it into the page content editor, above the Grid Gallery shortcode.', 'responsive-grid-gallery-custom-links');
            break;
        case 256:
            $out = __('6. You can add title or any other text above and between the shortcodes', 'responsive-grid-gallery-custom-links');
            break;
        case 257:
            $out = __('7. Save the page.', 'responsive-grid-gallery-custom-links');
            break;
        case 258:
            $out = __('8. Open the page for preview.', 'responsive-grid-gallery-custom-links');
            break;
        case 259:
            $out = __('9. Test category menu.', 'responsive-grid-gallery-custom-links');
            break;
//--------------------------------
        case 260:
            $out = __('Optional. Default: 100%. Valid formats: px, %. Example: 15px, 15%. No entry = default value.', 'responsive-grid-gallery-custom-links');
            break;
//--------------------------------
        case 300:
            $out = __('Field Label (Email Adress)', 'responsive-grid-gallery-custom-links');
            break;
//--------------------------------
        case 350:
            $out = __('', 'responsive-grid-gallery-custom-links');
            break;
        case 351:
            $out = __('Screen Min Width:', 'responsive-grid-gallery-custom-links');
            break;
        case 352:
            $out = __('', 'responsive-grid-gallery-custom-links');
            break;
        case 353:
            $out = __('', 'responsive-grid-gallery-custom-links');
            break;
        case 354:
            $out = __('Phones and other devices with screen resolution of 767 pixels or lower, will show a single column.', 'responsive-grid-gallery-custom-links');
            break;
        case 355:
            $out = __('', 'responsive-grid-gallery-custom-links');
            break;
        case 356:
            $out = __('', 'responsive-grid-gallery-custom-links');
            break;
        case 357:
            $out = __('Need more fields? With <a href="' . abcfrggcl_aurl(4) . '" target="_blank">Pro Version</a> you can have up to 10 fields.', 'responsive-grid-gallery-custom-links');
            break;
        default:
            $out = '';
            break;
    }
    return $out . $suffix;
}

function abcfrggcl_txta_r( $id, $suffix='' ) {
    $txt = abcfrggcl_txta( $id, $suffix );
    return $txt . '<b class="abcflRed abcflFontS14"> *</b>';
}

