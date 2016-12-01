package com.thomsonreuters.datamodel.client;

import java.util.List;

public class AttributeDefClient {
	
	private long id;
	private String name;
	private String caption;
	private String description;
	private String type;
	private String tag;
	private String renderInformation;
	private LookupDefClient lookup;

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
	public String getTag() {
		return tag;
	}
	public void setTag(String tag) {
		this.tag = tag;
	}
	public String getRenderInformation() {
		return renderInformation;
	}
	public void setRenderInformation(String renderInformation) {
		this.renderInformation = renderInformation;
	}
	public LookupDefClient getLookup() {
		return lookup;
	}
	public void setLookup(LookupDefClient lookup) {
		this.lookup = lookup;
	}	

}
