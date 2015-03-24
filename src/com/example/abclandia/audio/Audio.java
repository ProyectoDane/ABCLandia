package com.example.abclandia.audio;

import java.io.IOException;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import junit.framework.AssertionFailedError;

import android.app.Activity;
import android.content.Context;
import android.content.res.AssetFileDescriptor;
import android.media.AudioManager;
import android.media.SoundPool;
import com.example.abclandia.Card;
import com.frba.abclandia.R;

public class Audio {
	private static final String SOUND_FX_CORRECT = "correct";
	private static final String SOUND_FX_COMPLETE = "complete";
	private static final String SOUND_FX_WIN = "win";
	private static final String PLUS_ID_WORD = "0";
	private static final String PLUS_ID_LETTER = "1";
	private SoundPool mSoundPool;
	private Map<String, Integer> mSoundMap = new HashMap<String, Integer>();
	private Context mContext;

	private AudioManager mAudioManager;


	public Audio(Context context) {
		mAudioManager = (AudioManager) context
				.getSystemService(Context.AUDIO_SERVICE);
		mSoundPool = new SoundPool(1, AudioManager.STREAM_MUSIC, 0);
		mContext = context;

	}

	public void loadWordSounds(List<Card> cards) {

		for (Card card : cards) {
			loadSoundFromAssets("sonidos/palabras/", "w", card.getId());
		}
	}

	public void loadLetterSoungs(List<Card> cards) {

		for (Card card : cards) {
			loadSoundFromAssets("sonidos/letras/", "l", card.getId());
		}
	}
	
	private void loadSoundFromAssets(String assetFolder, String prefix, int id) {
		AssetFileDescriptor afd = null;
		try {
			afd = mContext.getAssets().openFd(assetFolder + id + ".ogg");
		} catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		mSoundMap.put(prefix + id, mSoundPool.load(afd, 1));
		;
	}

	public void playSoundWord(Integer soundId) {
		playSound("w" + soundId);
	}

	public void playSoundLetter(Integer soundId) {
		playSound("l" + soundId); 
	}

	public void loadDefaultSounds() {
		mSoundMap.put(SOUND_FX_CORRECT,
				mSoundPool.load(mContext, R.raw.correct, 1));
		mSoundMap.put(SOUND_FX_COMPLETE,
				mSoundPool.load(mContext, R.raw.complete, 1));
	}

	public void playCorrectSound() {
		playSound(SOUND_FX_CORRECT);
	}
	
	public void playCompleteSound() {
		playSound(SOUND_FX_COMPLETE);
	}
	
	private void playSound(String soundId){
		
		float streamVolume = mAudioManager.getStreamVolume(AudioManager.STREAM_MUSIC);
		mSoundPool.play(mSoundMap.get(soundId), streamVolume,streamVolume, 1, 0, 1f);
	}

}
