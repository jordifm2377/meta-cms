package com.thomsonreuters.cache;

import java.util.Map;

public interface MultiGetCache<T> {

	public Map<String, T> get(String... keys);
}