package com.thomsonreuters.datamodel;

public class AttributeDef {
	
	private long id;
	private String name;
	private String caption;
	private String description;
	private String type;
	private long lookupId;
	private long width;
	private long height;
	private long maxLength;
	private long imgWidth;
	private long imgHeight;
	private String tag;
	private String enabled;

	public long getId() {
		return id;
	}
	public void setId(long id) {
		this.id = id;
	}
	public String getName() {
		return name;
	}
	public void setName(String name) {
		this.name = name;
	}
	public String getCaption() {
		return caption;
	}
	public void setCaption(String caption) {
		this.caption = caption;
	}
	public String getDescription() {
		return description;
	}
	public void setDescription(String description) {
		this.description = description;
	}
	public String getType() {
		return type;
	}
	public void setType(String type) {
		this.type = type;
	}
	public long getLookupId() {
		return lookupId;
	}
	public void setLookupId(long lookupId) {
		this.lookupId = lookupId;
	}
	public long getWidth() {
		return width;
	}
	public void setWidth(long width) {
		this.width = width;
	}
	public long getHeight() {
		return height;
	}
	public void setHeight(long height) {
		this.height = height;
	}
	public long getMaxLength() {
		return maxLength;
	}
	public void setMaxLength(long maxLength) {
		this.maxLength = maxLength;
	}
	public long getImgWidth() {
		return imgWidth;
	}
	public void setImgWidth(long imgWidth) {
		this.imgWidth = imgWidth;
	}
	public long getImgHeight() {
		return imgHeight;
	}
	public void setImgHeight(long imgHeight) {
		this.imgHeight = imgHeight;
	}
	public String getTag() {
		return tag;
	}
	public void setTag(String tag) {
		this.tag = tag;
	}	
	public String getEnabled() {
		return enabled;
	}
	public void setEnabled(String enabled) {
		this.enabled = enabled;
	}

}
