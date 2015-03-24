package com.example.abclandia;



import java.util.List;
import android.app.Activity;
import android.content.Intent;
import android.content.res.Configuration;
import android.os.Bundle;
import android.os.Handler;
import android.view.MotionEvent;
import android.view.View;
import android.view.Window;
import android.view.WindowManager;
import com.example.abclandia.audio.Audio;
import com.example.abclandia.graphics.CardView;
import com.example.abclandia.graphics.JustLetterRenderer;
import com.example.abclandia.graphics.Renderer;
import com.frba.abclandia.dragdrop.DragController;
import com.frba.abclandia.dragdrop.DragLayer;
import com.frba.abclandia.dragdrop.DragSource;


public class GameActivity extends Activity implements View.OnTouchListener,
		DragController.DragListener {

	public static final int TOTAL_JOINS = 1;

	public static final String PACKAGE_NAME = "com.example.abclandia";
	public static final String INTENT_LEVEL_KEY = "level";
	public static final String INTENT_SECUENCE_KEY = "secuence";
	public static final String INTENT_CLASS_LAUNCHER_KEY = "class_launcher";
	public static final String INTENT_EXERCISE_NUMBER = "exercise";

	protected int countHits = 0;

	protected DragController mDragController;
	protected DragLayer mDragLayer;

	protected Renderer mDroppedRenderer;
	protected List<Card> data;

	private WindowManager.LayoutParams mWindowParams;
	private WindowManager mWindowManager;
	protected Audio mAudio;
	

	protected int mCurrrentLevel = 0;
	protected int mCurrentSecuence = 0;
	protected int mGameNumber = 0;
	protected int secuence = 0;
	protected String mGameClassName;
	
	protected int mTotalJoins;
	
	



	/**
	 * Called when the activity is first created.
	 */
	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);	
		setFullScreen();
		setSizes();
		getExtraData();
		loadDataCard();
		setSounds();
		
	}

	protected void setSounds() {
		mAudio = new Audio(this);
		mAudio.loadWordSounds(data);
	
		mAudio.loadDefaultSounds();
	}

	protected void setFullScreen() {
		requestWindowFeature(Window.FEATURE_NO_TITLE);
		getWindow().setFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN,
				WindowManager.LayoutParams.FLAG_FULLSCREEN);
		mWindowManager = (WindowManager) getSystemService("window");
	}

	protected void setSizes() {
		Configuration config = getResources().getConfiguration();
		if (config.smallestScreenWidthDp >= 720) {
			Renderer.TEXT_LETTER_SIZE = 25;
			Renderer.TEXT_WORD_SIZE = 23;
		} else if (config.smallestScreenWidthDp >= 600) {
			Renderer.TEXT_LETTER_SIZE = 20;
			Renderer.TEXT_WORD_SIZE = 18;
		}

	}

	protected void loadDataCard() {
		
		char[] secuenceLetters = GameDataStructure.getSecuence(mGameNumber,
				mCurrrentLevel, secuence);
		data = GameDataStructure.LoadDataCard(secuenceLetters);
	}
	

	protected void getExtraData() {
		Bundle extras = getIntent().getExtras();

		if (extras != null) {
			mCurrrentLevel = extras.getInt(GameActivity.INTENT_LEVEL_KEY, 1);
			secuence = extras.getInt(INTENT_SECUENCE_KEY, 1);
			
		}

	}


	@Override
	public boolean onTouch(View v, MotionEvent event) {

		boolean handledHere = false;
		CardView cardView = (CardView) v;
		final int action = event.getAction();

		// In the situation where a long click is not needed to initiate a drag,
		// simply start on the down event.
		if (action == MotionEvent.ACTION_DOWN) {

			if (!cardView.isEmptyCard() && cardView.allowDrag()) {
				Class<?> rendererClass = cardView.getRenderer().getClass();
				if (rendererClass == JustLetterRenderer.class){
					mAudio.playSoundLetter(cardView.getCardId());
				} else 
					mAudio.playSoundWord(cardView.getCardId());
				
					

			}

			handledHere = startDrag(v);
		}

		return handledHere;
	}

	public boolean startDrag(View v) {
		DragSource dragSource = (DragSource) v;

		// We are starting a drag. Let the DragController handle it.
		mDragController.startDrag(v, dragSource, dragSource,
				DragController.DRAG_ACTION_MOVE);

		return true;
	}

	public Renderer getMatchedRenderer() {
		return mDroppedRenderer;
	}

	@Override
	public void onDragStart(DragSource source, Object info, int dragAction) {
		// TODO Auto-generated method stub

	}


	@Override
	public void onDragEnd(boolean success, boolean isClick) {
		if (success) {
			mAudio.playCorrectSound();
			countHits++;

			if (countHits == mTotalJoins) {

				Handler handler = new Handler();
				handler.postDelayed(new Runnable() {
					public void run() {

						if (GameDataStructure.isExcersiseComplete(mGameNumber,
								mCurrrentLevel, secuence)) {
							Intent intent = new Intent(GameActivity.this,
									GameWinActivity.class);
							intent.putExtra(
									GameActivity.INTENT_CLASS_LAUNCHER_KEY,
									mGameClassName);
							
							startActivity(intent);

						} else {
							mAudio.playCompleteSound();

							Intent intent = new Intent(GameActivity.this,
									WinActivity.class);

							intent.putExtra(GameActivity.INTENT_LEVEL_KEY,
									mCurrrentLevel);
							intent.putExtra(GameActivity.INTENT_SECUENCE_KEY,
									secuence);
							intent.putExtra(
									GameActivity.INTENT_CLASS_LAUNCHER_KEY,
									mGameClassName);
							intent.putExtra(GameActivity.INTENT_EXERCISE_NUMBER, mGameNumber);

							startActivity(intent);
							finish();


						}

					}
				}, 500);
			}

		} else if (!isClick){
			
		}

		
	}

	public int getmGameNumber() {
		return mGameNumber;
	}

	public int getSecuence() {
		return secuence;
	}

	
	public int getNivel(){
		return mCurrrentLevel;
	}

	@Override
	public void onDragEnd(boolean success) {
		// TODO Auto-generated method stub
	}
	

}
