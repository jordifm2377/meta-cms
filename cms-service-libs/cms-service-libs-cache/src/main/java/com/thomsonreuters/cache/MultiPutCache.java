package com.thomsonreuters.cache;

import java.util.Map;

public interface MultiPutCache<T> {

	public void put(Map<String, T> pairs);
	public void putWithExpiration(Map<String, T> pairs, int seconds);

}