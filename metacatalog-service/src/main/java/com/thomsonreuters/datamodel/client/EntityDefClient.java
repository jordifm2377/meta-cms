package com.thomsonreuters.datamodel.client;

import java.util.ArrayList;
import java.util.List;

public class EntityDefClient {

	private long id;
	private String name;
	private String caption;
	private String description;
	private String tag;
	private String renderInformation;
	private long entityGroup;
	private List<AttributeDefClient> attributes = new ArrayList<>();
	private List<EntityDefClient> entities = new ArrayList<>();
	

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
	public long getEntityGroup() {
		return entityGroup;
	}
	public void setEntityGroup(long entityGroup) {
		this.entityGroup = entityGroup;
	}
	public List<AttributeDefClient> getAttributes() {
		return attributes;
	}
	public void setAttributes(List<AttributeDefClient> attributes) {
		this.attributes = attributes;
	}
	public List<EntityDefClient> getEntities() {
		return entities;
	}
	public void setEntities(List<EntityDefClient> entities) {
		this.entities = entities;
	}

}
