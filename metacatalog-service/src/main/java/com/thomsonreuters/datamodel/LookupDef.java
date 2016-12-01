package com.thomsonreuters.datamodel;

import java.util.ArrayList;
import java.util.List;

public class LookupDef {
	
	private long id;
	private String name;
	private String type;
	private long defaultId;
	private List<LookupValueDef> lookupValues;
	
	public LookupDef() {
		lookupValues = new ArrayList<>();
	}

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
	public String getType() {
		return type;
	}
	public void setType(String type) {
		this.type = type;
	}
	public long getDefaultId() {
		return defaultId;
	}
	public void setDefaultId(long defaultId) {
		this.defaultId = defaultId;
	}
	public List<LookupValueDef> getLookupValues() {
		return lookupValues;
	}
	public void setLookupValues(List<LookupValueDef> lookupValues) {
		this.lookupValues = lookupValues;
	}
	public void addLookupValue(long id, long lookupId, long order, String value, String caption) {
		this.lookupValues.add(new LookupValueDef(id, lookupId, order, value, caption));
	}

	public class LookupValueDef {
		private long id;
		private long lookupId;
		private long order;
		private String value;
		private String caption;
		
		public LookupValueDef(long id, long lookupId, long order, String value, String caption) {
			this.setId(id);
			this.setLookupId(lookupId);
			this.setOrder(order);
			this.setValue(value);
			this.setCaption(caption);
		}

		public long getId() {
			return id;
		}

		public void setId(long id) {
			this.id = id;
		}

		public long getLookupId() {
			return lookupId;
		}

		public void setLookupId(long lookupId) {
			this.lookupId = lookupId;
		}

		public long getOrder() {
			return order;
		}

		public void setOrder(long order) {
			this.order = order;
		}

		public String getValue() {
			return value;
		}

		public void setValue(String value) {
			this.value = value;
		}

		public String getCaption() {
			return caption;
		}

		public void setCaption(String caption) {
			this.caption = caption;
		}

	}

}
