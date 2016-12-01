package com.thomsonreuters.datamodel.client;

public class EntityAttributeDefClient {

	private long id;
	private long entityId;
	private long attrId;
	private long relId;
	private long row;
	private long column;
	private long width;
	private long height;
	private long imgWidth;
	private long imgHeight;
	private long orderKey;
	private String mandatory;
	private String enabled;
	

	public long getId() {
		return id;
	}
	public void setId(long id) {
		this.id = id;
	}
	public long getEntityId() {
		return entityId;
	}
	public void setEntityId(long entityId) {
		this.entityId = entityId;
	}
	public long getAttrId() {
		return attrId;
	}
	public void setAttrId(long attrId) {
		this.attrId = attrId;
	}
	public long getRelId() {
		return relId;
	}
	public void setRelId(long relId) {
		this.relId = relId;
	}
	public long getRow() {
		return row;
	}
	public void setRow(long row) {
		this.row = row;
	}
	public long getColumn() {
		return column;
	}
	public void setColumn(long column) {
		this.column = column;
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
	public long getOrderKey() {
		return orderKey;
	}
	public void setOrderKey(long orderKey) {
		this.orderKey = orderKey;
	}
	public String getMandatory() {
		return mandatory;
	}
	public void setMandatory(String mandatory) {
		this.mandatory = mandatory;
	}
	public String getEnabled() {
		return enabled;
	}
	public void setEnabled(String enabled) {
		this.enabled = enabled;
	}

}
