<?php declare(strict_types=1);

namespace Torr\Storyblok\Field\RichText;

enum RichTextStyling : string
{
	case Bold = "bold";
	case Italic = "italic";
	case Strikethrough = "strike";
	case Components = "blok";
	case Underline = "underline";
	case InlineCode = "inlinecode";
	case Code = "code";
	case Paragraph = "paragraph";
	case H1 = "h1";
	case H2 = "h2";
	case H3 = "h3";
	case H4 = "h4";
	case H5 = "h5";
	case H6 = "h6";
	case UnorderedList = "list";
	case OrderedList = "olist";
	case BlockQuote = "quote";
	case HorizontalLine = "hrule";
	case Link = "link";
	case Image = "image";
	case PasteMarkdown = "paste";
	case Subscript = "subscript";
	case Superscript = "superscript";
	case Color = "color";
	case Copy = "copy";
	case Cut = "cut";
	case Emoji = "emoji";
	case Anchor = "anchor";
	case Highlight = "highlight";
	case Redo = "redo";
	case Undo = "undo";
	case PasteActions = "paste-action";
	case UnsetFormatting = "unset";
}
