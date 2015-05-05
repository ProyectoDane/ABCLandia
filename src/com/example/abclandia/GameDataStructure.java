package com.example.abclandia;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.LinkedHashMap;
import java.util.List;
import java.util.Map;

public class GameDataStructure {
	
	private static final Map<Character, String> letterWords;
	private static final Map<Character, Integer> letterIds;
	
	private static final Map<Integer, char[]> e1L1Secuences;
	private static final Map<Integer, char[]> e1L2Secuences;
	private static final Map<Integer, char[]> e1L3Secuences;
	private static final Map<Integer, char[]> e45L1Secuences;
	private static final Map<Integer, char[]> e45L2Secuences;
	private static final Map<Integer, char[]> e45L3Secuences;
	private static final Map<Integer, char[]> e6L1Secuences;
	
	private static final Map<Integer, Map<Integer, char[]>> e123Levels;
	private static final Map<Integer, Map<Integer, char[]>> e45Levels;
	private static final Map<Integer, Map<Integer, char[]>> e6Levels;
	 
	private static final Map<Integer, Map<Integer,Map<Integer,char[]>>> excercises;
	private static final Map<Integer, Class<?>> excercisesClassName;
	 
	static {
		
		letterIds = new HashMap<Character, Integer>();
		letterIds.put('a',1);
		letterIds.put('b',2);
		letterIds.put('c',3);
		letterIds.put('d',4);
		letterIds.put('e',5);
		letterIds.put('f',6);
		letterIds.put('g',7);
		letterIds.put('h',8);
		letterIds.put('i',9);
		letterIds.put('j',10);
		letterIds.put('k',11);
		letterIds.put('l',12);
		letterIds.put('m',13);
		letterIds.put('n',14);
		letterIds.put('ñ',15);
		letterIds.put('o',16);
		letterIds.put('p',17);
		letterIds.put('q',18);
		letterIds.put('r',19);
		letterIds.put('s',20);
		letterIds.put('t',21);
		letterIds.put('u',22);
		letterIds.put('v',23);
		letterIds.put('w',24);
		letterIds.put('x',25);
		letterIds.put('y',26);
		letterIds.put('z',27);
		
		letterWords = new LinkedHashMap<Character,String>();
		letterWords.put('a', "auto");
		letterWords.put('b', "botella");
		letterWords.put('c', "conejo");
		letterWords.put('d', "dado");
		letterWords.put('e', "elefante");
		letterWords.put('f', "flor");
		letterWords.put('g', "gato");
		letterWords.put('h', "helado");
		letterWords.put('i', "indio");
		letterWords.put('j', "jirafa");
		letterWords.put('k', "kiosco");
		letterWords.put('l', "libro");
		letterWords.put('m', "manzana");
		letterWords.put('n', "naranja");
		letterWords.put('ñ', "ñoquis");
		letterWords.put('o', "oso");
		letterWords.put('p', "perro");
		letterWords.put('q', "queso");
		letterWords.put('r', "ratón");
		letterWords.put('s', "silla");
		letterWords.put('t', "tomate");
		letterWords.put('u', "uva");
		letterWords.put('v', "vaca");
		letterWords.put('w', "wall-e");
		letterWords.put('x', "xilofón");
		letterWords.put('y', "yo-yo");
		letterWords.put('z', "zapato");
		
		e1L1Secuences = new HashMap<Integer, char[]>();
		e1L1Secuences.put(1, new char[] { 'a', 'e', 'i', 'o', 'u' });
		e1L1Secuences.put(2, new char[] { 'a', 'e', 'm', 's', 'p' });
		e1L1Secuences.put(3, new char[] { 'i', 'o', 'u', 'm', 's' });
		e1L1Secuences.put(4, new char[] { 's', 'm', 'p', 'a', 'o' });
		e1L1Secuences.put(5, new char[] { 'i', 'u', 'l', 's', 'p' });
		e1L1Secuences.put(6, new char[] { 'l', 'p', 's', 'm', 't' });
		e1L1Secuences.put(7, new char[] { 't', 's', 'l', 'p', 'f' });
		e1L1Secuences.put(8, new char[] { 't', 'f', 'l', 'p', 'n' });
		e1L1Secuences.put(9, new char[] { 'n', 'p', 'l', 't', 'f' });

		e1L2Secuences = new HashMap<Integer, char[]>();
		e1L2Secuences.put(1, new char[] { 'n', 'f', 't', 'g', 'r' });
		e1L2Secuences.put(2, new char[] { 'r', 'f', 'g', 'n', 'd' });
		e1L2Secuences.put(3, new char[] { 'd', 'n', 'r', 'g', 'f' });
		e1L2Secuences.put(4, new char[] { 'g', 'd', 'n', 'b', 'r' });
		e1L2Secuences.put(5, new char[] { 'r', 'g', 'b', 'd', 'q' });
		e1L2Secuences.put(6, new char[] { 'q', 'd', 'b', 'j', 'c' });
		e1L2Secuences.put(7, new char[] { 'd', 'b', 'j', 'c', 'q' });
		e1L2Secuences.put(8, new char[] { 'b', 'q', 'j', 'c', 'h' });

		e1L3Secuences = new HashMap<Integer, char[]>();
		e1L3Secuences.put(1, new char[] { 'q', 'j', 'c', 'h', 'v' });
		e1L3Secuences.put(2, new char[] { 'v', 'j', 'c', 'h', 'z' });
		e1L3Secuences.put(3, new char[] { 'v', 'h', 'c', 'z', 'x' });
		e1L3Secuences.put(4, new char[] { 'h', 'z', 'v', 'x', 'y' });
		e1L3Secuences.put(5, new char[] { 'v', 'h', 'y', 'x', 'z' });
		e1L3Secuences.put(6, new char[] { 'z', 'y', 'x', 'w', 'ñ' });
		e1L3Secuences.put(7, new char[] { 'x', 'y', 'w', 'ñ', 'k' });
		e1L3Secuences.put(8, new char[] { 'y', 'w', 'ñ', 'k','v' });
		e1L3Secuences.put(9, new char[] { 'ñ', 'w', 'k', 'y','v' });

		e45L1Secuences = new HashMap<Integer, char[]>();
		e45L1Secuences.put(1, new char[] { 'a', 'e', 'o' });
		e45L1Secuences.put(2, new char[] { 'u', 'i', 's' });
		e45L1Secuences.put(3, new char[] { 'm', 'p', 'l' });
		e45L1Secuences.put(4, new char[] { 't', 'j', 'f' });

		e45L2Secuences = new HashMap<Integer, char[]>();
		e45L2Secuences.put(1, new char[] { 'v', 'c', 'w' });
		e45L2Secuences.put(2, new char[] { 'x', 'z', 'ñ' });

		e45L3Secuences = new HashMap<Integer, char[]>();
		e45L3Secuences.put(1, new char[] { 'q', 'y', 'r' });
		e45L3Secuences.put(2, new char[] { 'h', 'b', 'g' });
		e45L3Secuences.put(3, new char[] { 'd', 'k', 'n' });

		e6L1Secuences = new HashMap<Integer, char[]>();
		e6L1Secuences.put(1, new char[] { 'a', 'e', 'o' });
		e6L1Secuences.put(2, new char[] { 'm', 'u', 's' });
		e6L1Secuences.put(3, new char[] { 'p', 'i', 'l' });
		e6L1Secuences.put(4, new char[] { 'd', 'b', 'f' });
		e6L1Secuences.put(5, new char[] { 'e', 'a', 'o' });
		e6L1Secuences.put(6, new char[] { 'a', 'o', 'e' });
		e6L1Secuences.put(7, new char[] { 'o', 'n', 'r' });
		e6L1Secuences.put(8, new char[] { 'i', 'o', 'n' });

	}
	static {
		e123Levels = new HashMap<Integer, Map<Integer, char[]>>();
		e123Levels.put(1, e1L1Secuences);
		e123Levels.put(2, e1L2Secuences);
		e123Levels.put(3, e1L3Secuences);

		e45Levels = new HashMap<Integer, Map<Integer, char[]>>();
		e45Levels.put(1, e45L1Secuences);
		e45Levels.put(2, e45L2Secuences);
		e45Levels.put(3, e45L3Secuences);

		e6Levels = new HashMap<Integer, Map<Integer, char[]>>();
		e6Levels.put(1, e6L1Secuences);
	}
	static {
		excercises = new HashMap<Integer, Map<Integer, Map<Integer, char[]>>>();
		excercises.put(1, e123Levels);
		excercises.put(2, e123Levels);
		excercises.put(3, e123Levels);
		excercises.put(4, e45Levels);
		excercises.put(5, e45Levels);
		excercises.put(6, e6Levels);
		
		
		excercisesClassName = new HashMap<Integer,Class<?>>();
		excercisesClassName.put(1, GameOneActivity.class);
		excercisesClassName.put(2, GameTwoActivity.class);
		excercisesClassName.put(3, GameThreeActivity.class);
		excercisesClassName.put(4, GameFourActivity.class);
		excercisesClassName.put(5, GameFiveActivity.class);
		excercisesClassName.put(6, GameSixActivity.class);
	}
	    
	public static char[] getSecuence(int excerciseNumber, int levelNumber, int secuenceNumber){
		return excercises.get(excerciseNumber).get(levelNumber).get(secuenceNumber);
	}
	    
	public static boolean isLevelComplete(int exerciseNumber, int levelNumber, int secuenceNumber){
		return !excercises.get(exerciseNumber).get(levelNumber).containsKey(++secuenceNumber);
	}
	
	public static boolean isLastLevel(int exerciseNumber, int levelNumber){
		return excercises.get(exerciseNumber).containsKey(levelNumber);
	}
	    
	public static boolean isExcersiseComplete(int exerciseNumber,
			int levelNumber, int secuenceNumber) {

		if (excercises.get(exerciseNumber).get(levelNumber)
				.containsKey(++secuenceNumber)) {
			return false;
		}

		else if (excercises.get(exerciseNumber).containsKey(++levelNumber)) {
			return false;
		}
		return true;
	}
	
	public static Class<?> getExerciseClass(int exerciseNumber){
		return excercisesClassName.get(exerciseNumber);
	}
	
	
	public static List<Card> LoadDataCard(){
		List<Card> data = new ArrayList<Card>();

		for (Character letter : letterWords.keySet()) {
			int id = letterIds.get(letter);
			String word = letterWords.get(letter);
			String imagePath = "imagenes/" + id + ".jpg";
			Card card = new Card(id, letter.toString(), word, imagePath, "");
			card.setLetterType(1);
			data.add(card);
		}
		return data;
	}
	
	public static int GetLetterId(Character letter){
		return letterIds.get(letter);
	}
	
	public static List<Card> LoadDataCard(char[] secuence){
		
		List<Card> data = new ArrayList<Card>();
		
		for (Character letter : secuence) {
			
			int id = letterIds.get(letter);
			String word = letterWords.get(letter);
			
			String imagePath = "imagenes/" + id + ".jpg";
			Card card = new Card(id, letter.toString(), word, imagePath, "");
			card.setLetterType(1);
			
			data.add(card);
		}
		return data;
		
	}
	
	
	
}
