package com.thomsonreuters.datamodel;

public class EntityDef {

	private long id;
	private String name;
	private String caption;
	private String description;
	private long groupId;
	private long groupOrder;
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
	public long getGroupId() {
		return groupId;
	}
	public void setGroupId(long groupId) {
		this.groupId = groupId;
	}
	public long getGroupOrder() {
		return groupOrder;
	}
	public void setGroupOrder(long groupOrder) {
		this.groupOrder = groupOrder;
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
